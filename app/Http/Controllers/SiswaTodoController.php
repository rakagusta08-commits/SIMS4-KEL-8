<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiswaTodo;
use Illuminate\Support\Facades\Auth;

class SiswaTodoController extends Controller
{
    /**
     * Display to-do list untuk siswa yang login
     */
    public function index()
    {
        $siswa = Auth::guard('siswa')->user();
        
        $todos_pending = SiswaTodo::where('nis', $siswa->nis)
                                  ->pending()
                                  ->get();
        
        $todos_completed = SiswaTodo::where('nis', $siswa->nis)
                                    ->completed()
                                    ->limit(10)
                                    ->get();
        
        return view('siswa.todo.index', compact('todos_pending', 'todos_completed'));
    }

    /**
     * Show form untuk menambah to-do baru
     */
    public function create()
    {
        return view('siswa.todo.create');
    }

    /**
     * Simpan to-do baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'prioritas' => 'required|in:Rendah,Sedang,Tinggi',
            'deadline' => 'nullable|date|after:now'
        ]);

        $siswa = Auth::guard('siswa')->user();

        SiswaTodo::create([
            'nis' => $siswa->nis,
            'judul_tugas' => $request->judul_tugas,
            'deskripsi' => $request->deskripsi,
            'prioritas' => $request->prioritas,
            'deadline' => $request->deadline
        ]);

        return redirect()->route('siswa.todo.index')
                       ->with('success', 'To-do baru berhasil ditambahkan! 🎯');
    }

    /**
     * Show form untuk edit to-do
     */
    public function edit($id)
    {
        $todo = SiswaTodo::findOrFail($id);
        
        // Proteksi: Siswa hanya bisa edit todo milik mereka sendiri
        if ($todo->nis !== Auth::guard('siswa')->user()->nis) {
            return redirect()->route('siswa.todo.index')
                          ->with('error', 'Akses ditolak!');
        }

        return view('siswa.todo.edit', compact('todo'));
    }

    /**
     * Update to-do
     */
    public function update(Request $request, $id)
    {
        $todo = SiswaTodo::findOrFail($id);
        
        if ($todo->nis !== Auth::guard('siswa')->user()->nis) {
            return redirect()->route('siswa.todo.index')
                          ->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'prioritas' => 'required|in:Rendah,Sedang,Tinggi',
            'deadline' => 'nullable|date'
        ]);

        $todo->update($request->only(['judul_tugas', 'deskripsi', 'prioritas', 'deadline']));

        return redirect()->route('siswa.todo.index')
                       ->with('success', 'To-do berhasil diperbarui!');
    }

    /**
     * Tandai to-do sebagai selesai (via AJAX)
     */
    public function complete($id)
    {
        $todo = SiswaTodo::findOrFail($id);
        
        if ($todo->nis !== Auth::guard('siswa')->user()->nis) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $todo->update([
            'sudah_selesai' => true,
            'selesai_pada' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => '✅ Tugas ditandai selesai!',
            'todo_id' => $todo->id
        ]);
    }

    /**
     * Tandai to-do sebagai belum selesai
     */
    public function uncomplete($id)
    {
        $todo = SiswaTodo::findOrFail($id);
        
        if ($todo->nis !== Auth::guard('siswa')->user()->nis) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $todo->update([
            'sudah_selesai' => false,
            'selesai_pada' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => '↩️ Tugas ditandai belum selesai!',
            'todo_id' => $todo->id
        ]);
    }

    /**
     * Hapus to-do
     */
    public function destroy($id)
    {
        $todo = SiswaTodo::findOrFail($id);
        
        if ($todo->nis !== Auth::guard('siswa')->user()->nis) {
            return redirect()->route('siswa.todo.index')
                          ->with('error', 'Akses ditolak!');
        }

        $todo->delete();

        return redirect()->route('siswa.todo.index')
                       ->with('success', 'To-do berhasil dihapus!');
    }

    /**
     * Hapus semua to-do yang sudah selesai
     */
    public function clearCompleted()
    {
        $siswa = Auth::guard('siswa')->user();
        
        $count = SiswaTodo::where('nis', $siswa->nis)
                         ->where('sudah_selesai', true)
                         ->delete();

        return redirect()->route('siswa.todo.index')
                       ->with('success', "{$count} tugas yang sudah selesai telah dihapus!");
    }
}
