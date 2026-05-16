<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    // 🚀 HELPER: Bikin variasi nama kelas (angka ↔ Romawi)
    private function kelasVariants($nama_kelas)
    {
        $nama_kelas = trim($nama_kelas);
        $variants = [$nama_kelas];

        // Map angka ↔ Romawi
        $maps = [
            ['12', 'XII'],
            ['11', 'XI'],
            ['10', 'X'],
        ];

        foreach ($maps as [$num, $rom]) {
            // Angka → Romawi (contoh: "11 RPL 1" → "XI RPL 1")
            if (preg_match('/^' . $num . '\s/', $nama_kelas)) {
                $variants[] = preg_replace('/^' . $num . '\s/', $rom . ' ', $nama_kelas);
            }
            // Romawi → Angka (contoh: "XI RPL 1" → "11 RPL 1")
            if (preg_match('/^' . $rom . '\s/i', $nama_kelas)) {
                $variants[] = preg_replace('/^' . $rom . '\s/i', $num . ' ', $nama_kelas);
            }
        }

        return array_unique($variants);
    }

    // 1. Tampilkan semua jadwal di sisi Admin/Guru (NGE-BLOK PER KELAS)
    public function index()
    {
        $nama_kelas = session('nama_kelas_aktif');

        $query = Jadwal::orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
                       ->orderBy('jam_mulai', 'asc');

        // 🚀 Filter dengan dukungan format angka & Romawi
        if ($nama_kelas) {
            $variants = $this->kelasVariants($nama_kelas);
            $query->where(function ($q) use ($variants) {
                foreach ($variants as $v) {
                    $q->orWhere('kelas', $v);
                }
            });
        }

        $jadwals = $query->get();
        $jadwal_per_kelas = $jadwals->groupBy('kelas');

        return view('guru.jadwal.index', compact('jadwals', 'jadwal_per_kelas', 'nama_kelas'));
    }

    // 2. Form Tambah Jadwal
    public function create()
    {
        $data_kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        return view('guru.jadwal.create', compact('data_kelas'));
    }

    // 3. Simpan Jadwal Baru
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'mata_pelajaran' => 'required',
            'kelas' => 'required',
        ]);

        Jadwal::create($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    // 4. Hapus Jadwal
    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus!');
    }

    // 5. Tampilkan jadwal khusus untuk SISWA yang login
    public function siswaIndex()
    {
        $siswa = Auth::guard('siswa')->user();

        $nama_kelas_siswa = is_object($siswa->kelas) ? $siswa->kelas->nama_kelas : $siswa->kelas;

        if (empty($nama_kelas_siswa)) {
            $jadwal = collect();
        } else {
            // 🚀 Filter dengan dukungan format angka & Romawi
            $variants = $this->kelasVariants($nama_kelas_siswa);

            $jadwal = Jadwal::where(function ($q) use ($variants) {
                                foreach ($variants as $v) {
                                    $q->orWhere('kelas', $v);
                                }
                            })
                            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
                            ->orderBy('jam_mulai', 'asc')
                            ->get();
        }

        $jadwals = $jadwal;

        return view('siswa.jadwal', compact('jadwal', 'jadwals', 'siswa'));
    }

    // 6. Form Edit Jadwal
    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $data_kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        return view('guru.jadwal.edit', compact('jadwal', 'data_kelas'));
    }

    // 7. Update Jadwal
    public function update(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'mata_pelajaran' => 'required',
            'kelas' => 'required',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }
}