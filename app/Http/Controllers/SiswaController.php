<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa; 
use App\Models\Kelas; 
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    // 1. Menampilkan Daftar Siswa (DENGAN FILTER KELAS AKTIF)
    public function index(Request $request)
    {
        $user = Auth::guard('guru')->user();
        $id_kelas_aktif = session('id_kelas_aktif');
        $search = $request->get('search');

        // LOGIKA FILTER:
        // Jika Admin: Bisa lihat semua (all), tapi kalau dia pilih kelas, kita filter juga.
        // Jika Guru Mapel/Wali Kelas: Wajib filter berdasarkan kelas yang sedang dibuka.
        
        $query = Siswa::query();
        
        if ($id_kelas_aktif) {
            // Ambil nama kelas dulu untuk filter string di kolom 'kelas'
            $kelas = Kelas::find($id_kelas_aktif);
            $query->where('kelas', 'LIKE', '%' . $kelas->nama_kelas . '%');
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_siswa', 'LIKE', '%' . $search . '%')
                  ->orWhere('nis', 'LIKE', '%' . $search . '%')
                  ->orWhere('kelas', 'LIKE', '%' . $search . '%');
            });
        }
        
        $data_siswa = $query->get();

        return view('guru.siswa.index', compact('data_siswa', 'search'));
    }

    // 2. Menampilkan Form Tambah Siswa
    public function create()
    {
        $data_kelas = Kelas::all(); 
        return view('guru.siswa.tambah.create', compact('data_kelas')); 
    }

    // 3. Menyimpan Data Siswa Baru
    public function store(Request $request)
    {
        $request->validate([
            'nis'        => 'required|numeric|unique:siswas,nis',
            'nama_siswa' => 'required',
            'kelas'      => 'required',
            'jenkel'     => 'required',
        ]);

        Siswa::create([
            'nis'        => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'kelas'      => $request->kelas,
            'jenkel'     => $request->jenkel,
            'alamat'     => $request->alamat ?? '-',
            'password'   => bcrypt('siswa123'),
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data Berhasil Disimpan');
    }

    // 4. Menampilkan Halaman Edit Siswa
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $data_kelas = Kelas::all();
        return view('guru.siswa.tambah.edit', compact('siswa', 'data_kelas'));
    }

    // 5. Memproses Update Data
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis'        => 'required|numeric|unique:siswas,nis,'.$id,
            'nama_siswa' => 'required',
            'kelas'      => 'required',
            'jenkel'     => 'required',
        ]);

        $siswa->nis        = $request->nis;
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->kelas      = $request->kelas;
        $siswa->jenkel     = $request->jenkel;
        $siswa->alamat     = $request->alamat;

        if($request->filled('password')) {
            $siswa->password = bcrypt($request->password);
        }

        $siswa->save();

        return redirect()->route('siswa.index')->with('success', 'Data Siswa Berhasil Diperbarui!');
    }

    // 6. Menghapus Data Siswa
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data Siswa Berhasil Dihapus!');
    }

    // 7. Print Laporan (IKUT TERFILTER)
    public function printLaporan()
    {
        $id_kelas_aktif = session('id_kelas_aktif');

        if ($id_kelas_aktif) {
            $kelas = Kelas::find($id_kelas_aktif);
            $data_siswa = Siswa::where('kelas', 'LIKE', '%' . $kelas->nama_kelas . '%')->get();
        } else {
            $data_siswa = Siswa::all();
        }

        return view('guru.print', compact('data_siswa'));
    }
}