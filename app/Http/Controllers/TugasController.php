<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Kelas;
use App\Models\Siswa; 
use App\Models\PengumpulanTugas; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 

class TugasController extends Controller
{
    // ==========================================
    // BAGIAN 1: KHUSUS GURU (CRUD & KOREKSI)
    // ==========================================

    public function index() {
        $id_kelas_aktif = session('id_kelas_aktif');
        $kelas = Kelas::find($id_kelas_aktif);
        $user = Auth::guard('guru')->user();

        // 🚀 LOGIKA FILTER PRIVASI GURU
        $query = Tugas::query();

        // 1. Filter berdasarkan kelas yang sedang aktif
        if ($id_kelas_aktif) {
            $query->where('kelas', 'LIKE', '%' . $kelas->nama_kelas . '%');
        }

        // 2. Filter berdasarkan Guru (Kecuali Admin bisa lihat semua)
        if ($user->role != 'admin') {
            $query->where('guru_id', $user->id);
        }

        $tugas = $query->orderBy('deadline', 'asc')->get();

        return view('guru.tugas.index', compact('tugas'));
    }

    public function create() {
        $id_kelas_aktif = session('id_kelas_aktif');
        
        // Agar saat buat tugas, input "Kelas" otomatis terisi kelas yang sedang aktif
        $kelas_aktif = Kelas::find($id_kelas_aktif);
        $data_kelas = Kelas::all();
        
        return view('guru.tugas.create', compact('data_kelas', 'kelas_aktif'));
    }

    public function store(Request $request) {
        $request->validate([
            'mapel'         => 'required', 
            'judul'         => 'required', 
            'kelas'         => 'required', 
            'deadline'      => 'required', 
            'deskripsi'     => 'required',
            'link'          => 'nullable|url', // Validasi input URL (bisa kosong)
            'file_lampiran' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,zip,png,jpg,jpeg,gif|max:5120' // Mengizinkan gambar
        ]);

        $tugas = new Tugas;
        // 🚀 SIMPAN ID GURU PEMBUAT TUGAS
        $tugas->guru_id     = Auth::guard('guru')->user()->id; 
        
        $tugas->mapel       = $request->mapel;
        $tugas->judul_tugas = $request->judul; 
        $tugas->kelas       = $request->kelas;
        $tugas->deadline    = $request->deadline;
        $tugas->deskripsi   = $request->deskripsi;
        
        // 🚀 SIMPAN LINK JIKA ADA
        $tugas->link        = $request->link; 
        
        // 🚀 UPLOAD FILE / GAMBAR
        if ($request->hasFile('file_lampiran')) {
            $file = $request->file('file_lampiran');
            $filename = time() . '_' . $file->getClientOriginalName(); 
            $file->storeAs('uploads/tugas', $filename, 'public');
            $tugas->file_lampiran = $filename; // Simpan ke kolom 'file_lampiran' sesuai migration baru
        }

        $tugas->save();
        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dikirim ke kelas ' . $request->kelas);
    }

    public function edit($id) {
        $tugas = Tugas::findOrFail($id);
        $user = Auth::guard('guru')->user();

        // 🚀 PROTEKSI URL: Cegah guru ngedit tugas orang lain via URL
        if ($user->role != 'admin' && $tugas->guru_id != $user->id) {
            return redirect()->route('tugas.index')->with('error', 'Akses Ditolak! Ini bukan tugas buatanmu, Gus!');
        }

        $data_kelas = Kelas::all();
        return view('guru.tugas.edit', compact('tugas', 'data_kelas'));
    }

    public function update(Request $request, $id) {
        $tugas = Tugas::findOrFail($id);
        $user = Auth::guard('guru')->user();

        // 🚀 PROTEKSI
        if ($user->role != 'admin' && $tugas->guru_id != $user->id) {
            return redirect()->route('tugas.index')->with('error', 'Akses Ditolak!');
        }

        $request->validate([
            'mapel'         => 'required', 
            'judul'         => 'required',
            'kelas'         => 'required', 
            'deadline'      => 'required', 
            'deskripsi'     => 'required',
            'link'          => 'nullable|url', // Validasi input URL
            'file_lampiran' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,zip,png,jpg,jpeg,gif|max:5120' // Mengizinkan gambar
        ]);

        $tugas->mapel       = $request->mapel;
        $tugas->judul_tugas = $request->judul; 
        $tugas->kelas       = $request->kelas;
        $tugas->deadline    = $request->deadline;
        $tugas->deskripsi   = $request->deskripsi;
        
        // 🚀 UPDATE LINK
        $tugas->link        = $request->link;

        // 🚀 UPDATE FILE / GAMBAR
        if ($request->hasFile('file_lampiran')) {
            // Hapus file lama jika ada
            if ($tugas->file_lampiran) {
                Storage::disk('public')->delete('uploads/tugas/' . $tugas->file_lampiran);
            }
            $file = $request->file('file_lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/tugas', $filename, 'public');
            $tugas->file_lampiran = $filename;
        }

        $tugas->save();
        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy($id) {
        $tugas = Tugas::findOrFail($id);
        $user = Auth::guard('guru')->user();

        // 🚀 PROTEKSI
        if ($user->role != 'admin' && $tugas->guru_id != $user->id) {
            return redirect()->route('tugas.index')->with('error', 'Akses Ditolak!');
        }

        if ($tugas->file_lampiran) {
            Storage::disk('public')->delete('uploads/tugas/' . $tugas->file_lampiran);
        }
        $tugas->delete();
        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus!');
    }

    public function koreksi($id) {
        $tugas = Tugas::findOrFail($id);
        $user = Auth::guard('guru')->user();

        // 🚀 PROTEKSI
        if ($user->role != 'admin' && $tugas->guru_id != $user->id) {
            return redirect()->route('tugas.index')->with('error', 'Gus, kamu gak berhak ngoreksi tugas guru lain!');
        }
        
        $jawaban_siswa = PengumpulanTugas::with('siswa')
                                         ->where('tugas_id', $id)
                                         ->get();
                                         
        $semua_siswa = Siswa::where('kelas', $tugas->kelas)->get();

        return view('guru.tugas.koreksi', compact('tugas', 'jawaban_siswa', 'semua_siswa'));
    }

    public function simpanNilai(Request $request, $id) {
        $jawaban = PengumpulanTugas::findOrFail($id);
        
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100'
        ]);

        $jawaban->nilai = $request->nilai;
        $jawaban->save();

        return back()->with('success', 'Nilai berhasil disimpan!');
    }

    // ==========================================
    // BAGIAN 2: KHUSUS SISWA
    // ==========================================

    public function tugasSiswa() {
        $siswa = Auth::guard('siswa')->user();
        
        // Siswa bebas lihat semua tugas dari guru mana pun, selama itu buat kelasnya dia
        $data_tugas = Tugas::where('kelas', 'LIKE', '%' . $siswa->kelas . '%')
                      ->orderBy('deadline', 'asc')
                      ->get();

        return view('siswa.tugas', compact('data_tugas'));
    }

    // 🚀 LOGIKA MULTIPLE UPLOAD & KOMENTAR (ALA CLASSROOM)
    public function kumpulTugas(Request $request, $id) {
        $request->validate([
            'file_jawaban.*' => 'required|mimes:pdf,doc,docx,zip,png,jpg,jpeg|max:5120',
            'komentar'       => 'nullable|string'
        ]);

        $siswa = Auth::guard('siswa')->user();
        $files = [];

        // Logika upload banyak file sekaligus
        if ($request->hasFile('file_jawaban')) {
            foreach ($request->file('file_jawaban') as $file) {
                // Menggunakan uniqid agar nama file unik di server
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/jawaban', $filename, 'public');
                $files[] = $filename;
            }
        }

        // Simpan data (jika sudah ada, maka akan diupdate / Mode Timpa)
        PengumpulanTugas::updateOrCreate(
            ['tugas_id' => $id, 'nis' => $siswa->nis],
            [
                'file_jawaban' => $files, // Disimpan sebagai array/JSON otomatis
                'komentar'     => $request->komentar
            ]
        );

        return back()->with('success', 'Jawaban berhasil dikumpulkan! Semangat!');
    }
}