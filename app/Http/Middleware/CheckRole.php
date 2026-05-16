<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Cek apakah sudah login sebagai guru
        if (!Auth::guard('guru')->check()) {
            return redirect('/login/guru');
        }

        $user = Auth::guard('guru')->user();

        // 2. Cek apakah role user ada dalam daftar role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. Kalau tidak punya akses, lempar balik ke dashboard dengan pesan error
        return redirect()->route('guru.dashboard')->with('error', 'Waduh! Kamu nggak punya akses ke halaman itu, Gus.');
    }
}