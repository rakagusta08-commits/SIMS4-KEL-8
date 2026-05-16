<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    // 1. Tampil Daftar Kelas
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        if ($search) {
            $data_kelas = Kelas::where('nama_kelas', 'LIKE', '%' . $search . '%')
                ->orWhere('kompetensi_keahlian', 'LIKE', '%' . $search . '%')
                ->get();
        } else {
            $data_kelas = Kelas::all();
        }
        
        return view('guru.data_kelas.index', compact('data_kelas', 'search'));
    }

    // 2. Tampil Form Tambah
    public function create()
    {
        return view('guru.data_kelas.create');
    }

    // 3. Simpan Data ke Database
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'kompetensi_keahlian' => 'required',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'kompetensi_keahlian' => $request->kompetensi_keahlian,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan!');
    }

    // 4. Hapus Data
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }

    // --- TAMBAHAN DARI SAYA (FITUR EDIT & UPDATE) ---

    // 5. Menampilkan Form Edit
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('guru.data_kelas.edit', compact('kelas'));
    }

    // 6. Memproses Perubahan Data (Update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'kompetensi_keahlian' => 'required',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'kompetensi_keahlian' => $request->kompetensi_keahlian,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diubah!');
    }
}