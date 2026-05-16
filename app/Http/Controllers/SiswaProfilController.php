<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class SiswaProfilController extends Controller
{
    public function edit()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('siswa.profil.edit', compact('siswa'));
    }

    public function update(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();
        
        $request->validate([
            'nama_siswa'    => 'required|string|max:100',
            'alamat'        => 'nullable|string|max:255',
            'no_hp'         => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir'  => 'nullable|string|max:100',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'agama'         => 'nullable|string|max:50',
            'nama_ortu'     => 'nullable|string|max:100',
        ]);

        // Update data siswa
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->alamat = $request->alamat;
        $siswa->no_hp = $request->no_hp;
        $siswa->tanggal_lahir = $request->tanggal_lahir;
        $siswa->tempat_lahir = $request->tempat_lahir;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->agama = $request->agama;
        $siswa->nama_ortu = $request->nama_ortu;
        $siswa->save();

        return redirect()->route('siswa.profil')->with('success', '✅ Profil berhasil diperbarui!');
    }
}
