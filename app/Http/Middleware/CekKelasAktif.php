<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekKelasAktif
{
    public function handle(Request $request, Closure $next)
    {
        // Jika yang login adalah Admin, langsung loloskan saja
        if (Auth::guard('guru')->check() && Auth::guard('guru')->user()->role == 'admin') {
            return $next($request);
        }

        // Jika Guru biasa (Mapel/Wali) belum pilih kelas
        if (!session()->has('id_kelas_aktif')) {
            // Arahkan kembali ke halaman dashboard dengan pesan error
            return redirect()->route('guru.dashboard')
                             ->with('error', 'Akses Terkunci! Pilih kelas terlebih dahulu ya, Gus.');
        }

        return $next($request);
    }
}