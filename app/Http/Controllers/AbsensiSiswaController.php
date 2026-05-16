<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Penting buat simpan foto
use App\Models\Absensi;
use App\Models\Kelas;
use Carbon\Carbon;

class AbsensiSiswaController extends Controller
{
    // 1. TAMPILKAN HALAMAN ABSEN
    public function index()
    {
        $siswa = Auth::guard('siswa')->user();
        $hari_ini = Carbon::today();

        // Cek apakah siswa SUDAH absen hari ini?
        $cek_absen = Absensi::where('nis', $siswa->nis)
                            ->where('tanggal', $hari_ini)
                            ->first();

        return view('siswa.absensi.index', compact('siswa', 'cek_absen'));
    }

    // 2. PROSES SIMPAN ABSEN + FOTO SELFIE
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'foto_webcam' => 'required', // Wajib ada foto
        ]);

        $siswa = Auth::guard('siswa')->user();
        
        // Cari ID Kelas berdasarkan nama kelas siswa
        $kelas = Kelas::where('nama_kelas', $siswa->kelas)->first();
        
        if(!$kelas) {
            return back()->with('error', 'Data kelas tidak ditemukan! Hubungi Admin.');
        }

        // --- PROSES MENYIMPAN FOTO DARI WEBCAM (BASE64) ---
        $image_parts = explode(";base64,", $request->foto_webcam);
        $image_base64 = base64_decode($image_parts[1]);
        
        // Nama file unik: absen_NIS_TANGGAL.jpg
        $nama_file = 'absen_' . $siswa->nis . '_' . date('Ymd_His') . '.jpg';
        
        // Simpan ke folder: storage/app/public/uploads/absensi/
        Storage::disk('public')->put('uploads/absensi/' . $nama_file, $image_base64);

        // --- SIMPAN KE DATABASE ---
        Absensi::create([
            'nis' => $siswa->nis,
            'kelas_id' => $kelas->id,
            'tanggal' => Carbon::today(),
            'status' => $request->status,
            'keterangan' => $request->keterangan, // Opsional (diisi kalau sakit/izin)
            'foto_bukti' => $nama_file, // Nama file foto disimpan di sini
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil! Foto kamu sudah tersimpan.');
    }
}