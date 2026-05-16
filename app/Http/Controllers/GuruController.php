<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\Guru;
use Carbon\Carbon;

class GuruController extends Controller
{
    // ==========================================================
    // 📊 DASHBOARD UTAMA
    // ==========================================================
    public function dashboard()
    {
        $guru = Auth::guard('guru')->user();
        $id_kelas_aktif   = session('id_kelas_aktif');
        $nama_kelas_aktif = session('nama_kelas_aktif');

        // 🚀 Konversi nomor hari → nama hari Indonesia (sesuai data DB)
        $hariMap = [
            0 => 'Minggu', 1 => 'Senin', 2 => 'Selasa',
            3 => 'Rabu',   4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu'
        ];
        $hari_ini = $hariMap[now()->dayOfWeek] ?? 'Senin';

        // 🚀 Ambil JADWAL KELAS AKTIF hari ini (support format angka & Romawi)
        $jadwal_hari_ini = collect();
        if ($nama_kelas_aktif) {
            $variants = $this->kelasVariants($nama_kelas_aktif);

            $jadwal_hari_ini = Jadwal::where('hari', $hari_ini)
                ->where(function ($q) use ($variants) {
                    foreach ($variants as $v) {
                        $q->orWhere('kelas', $v);
                    }
                })
                ->orderBy('jam_mulai')
                ->get();
        }

        // Total siswa & tugas
        if ($id_kelas_aktif && $guru->role != 'admin') {
            $jumlah_siswa = Siswa::where('kelas_id', $id_kelas_aktif)->count();
            $jumlah_tugas = Tugas::where('kelas_id', $id_kelas_aktif)->count();
        } else {
            $jumlah_siswa = Siswa::count();
            $jumlah_tugas = Tugas::count();
        }

        $jumlah_guru  = Guru::count();
        $jumlah_kelas = Kelas::count();

        // Statistik absensi (sementara 0)
        $hadir = 0; $sakit = 0; $izin = 0; $alpa = 0;

        // Tugas terbaru
        $tugas_terbaru = Tugas::orderBy('deadline', 'desc')->limit(3)->get();

        return view('guru.dashboard', [
            'jadwal_hari_ini'   => $jadwal_hari_ini,
            'hari_ini'          => $hari_ini,
            'nama_kelas_aktif'  => $nama_kelas_aktif,
            'jumlah_siswa'      => $jumlah_siswa,
            'jumlah_guru'       => $jumlah_guru,
            'jumlah_kelas'      => $jumlah_kelas,
            'jumlah_tugas'      => $jumlah_tugas,
            'hadir'             => $hadir,
            'sakit'             => $sakit,
            'izin'              => $izin,
            'alpa'              => $alpa,
            'tugas_terbaru'     => $tugas_terbaru,
            'guru'              => $guru
        ]);
    }

    // 🚀 HELPER: Bikin variasi nama kelas (angka ↔ Romawi)
    private function kelasVariants($nama_kelas)
    {
        $nama_kelas = trim($nama_kelas);
        $variants = [$nama_kelas];

        $maps = [
            ['12', 'XII'],
            ['11', 'XI'],
            ['10', 'X'],
        ];

        foreach ($maps as [$num, $rom]) {
            if (preg_match('/^' . $num . '\s/', $nama_kelas)) {
                $variants[] = preg_replace('/^' . $num . '\s/', $rom . ' ', $nama_kelas);
            }
            if (preg_match('/^' . $rom . '\s/i', $nama_kelas)) {
                $variants[] = preg_replace('/^' . $rom . '\s/i', $num . ' ', $nama_kelas);
            }
        }

        return array_unique($variants);
    }

    // ==========================================================
    // 📝 CRUD DATA GURU (FITUR SEARCH DITAMBAHKAN DI SINI)
    // ==========================================================
    public function index(Request $request)
    {
        $keyword = $request->search;

        if ($keyword) {
            $data_guru = Guru::where('nama_guru', 'LIKE', '%' . $keyword . '%')
                             ->orWhere('nip', 'LIKE', '%' . $keyword . '%')
                             ->get();
        } else {
            $data_guru = Guru::all();
        }

        return view('guru.data_guru.index', compact('data_guru'));
    }

    public function create()
    {
        return view('guru.data_guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:gurus,nip',
            'nama_guru' => 'required',
            'password' => 'required|min:6',
        ]);

        Guru::create([
            'nip' => $request->nip,
            'nama_guru' => $request->nama_guru,
            'mata_pelajaran' => $request->mata_pelajaran ?? '-',
            'password' => bcrypt($request->password), 
        ]);

        return redirect()->route('guru.index')->with('success', 'Berhasil menambahkan guru baru!');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('guru.data_guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|unique:gurus,nip,'.$id,
            'nama_guru' => 'required',
            'mata_pelajaran' => 'required',
            'role' => 'required', 
        ]);

        $guru = Guru::findOrFail($id);
        
        $guru->update([
            'nip' => $request->nip,
            'nama_guru' => $request->nama_guru,
            'mata_pelajaran' => $request->mata_pelajaran,
            'role' => $request->role, 
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus!');
    }

    // ==========================================================
    // 🚀 FITUR KELOLA KELAS AKTIF
    // ==========================================================

    public function selectClass() 
    {
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get(); 
        return view('guru.pilih-kelas', compact('kelas'));
    }

    public function pilihKelas() 
    {
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get(); 
        return view('guru.pilih-kelas', compact('kelas'));
    }

    public function setKelas($id) 
    {
        $kelas = Kelas::findOrFail($id);
        
        session(['id_kelas_aktif' => $id]);
        session(['nama_kelas_aktif' => $kelas->nama_kelas]);

        return redirect()->route('guru.dashboard')->with('success', 'Berhasil masuk ke Kelas ' . $kelas->nama_kelas);
    }

    public function keluarKelas()
    {
        session()->forget(['id_kelas_aktif', 'nama_kelas_aktif']);
        return redirect()->route('guru.pilih-kelas')->with('success', 'Silakan pilih kelas kembali.');
    }
}