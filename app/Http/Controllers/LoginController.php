<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // 1. HALAMAN PORTAL UTAMA
    public function indexPortal()
    {
        return view('auth.pilih-portal'); 
    }

    // 2. HALAMAN LOGIN SISWA
    public function index()
    {
        return view('auth.login-siswa'); 
    }

    // 3. PROSES LOGIN SISWA (🚀 SUDAH FIX 1000%!)
    public function login(Request $request)
    {
        // Ubah validasi menjadi 'username' karena form HTML kamu ngirimnya 'username'
        $request->validate([
            'username' => 'required', 
            'password' => 'required'
        ]);

        // Kita cocokkan: Cari di kolom 'nis' database yang nilainya sama dengan input 'username' dari form
        $cek_login = Auth::guard('siswa')->attempt([
            'nis' => $request->username, 
            'password' => $request->password
        ]);

        if ($cek_login) {
            $request->session()->regenerate();
            
            // 🚀 DEBUG: Log session info
            \Log::info('Login Siswa Berhasil', [
                'nis' => $request->username,
                'session_id' => session()->getId(),
                'auth_check' => Auth::guard('siswa')->check(),
                'auth_user' => Auth::guard('siswa')->user()?->nis,
            ]);
            
            return redirect()->route('siswa.dashboard')->with('success', 'Berhasil login sebagai Siswa!');
        } else {
            return back()->with('error', 'NIS atau Password salah, Gus!');
        }
    }

    // 4. HALAMAN LOGIN GURU
    public function indexGuru()
    {
        return view('auth.login-guru'); 
    }

    // 5. PROSES LOGIN GURU (🚀 SUDAH FIX ANTI-LOOPING!)
    public function loginGuru(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required', 
            'password' => 'required'
        ]);

        // Proses login guru pakai NIP
        if (Auth::guard('guru')->attempt(['nip' => $request->email, 'password' => $request->password])) {
            
            $request->session()->regenerate();
            $user = Auth::guard('guru')->user();

            // 🚀 PERBAIKAN DI SINI: Pakai strtolower() dan trim() biar kebal huruf besar/kecil & spasi!
            if (strtolower(trim($user->role)) === 'admin') {
                return redirect()->route('guru.dashboard')->with('success', 'Selamat datang kembali, Admin!');
            } else {
                return redirect()->route('guru.pilih-kelas')->with('success', 'Berhasil login! Silakan pilih kelas.');
            }
        }

        return back()->with('error', 'NIP atau Password salah, Gus! Coba lagi.');
    }

    // 6. LOGOUT GLOBAL
    public function logout(Request $request)
    {
        if (Auth::guard('guru')->check()) {
            Auth::guard('guru')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login.guru')->with('success', 'Berhasil logout!');
        } 
        
        if (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login.siswa')->with('success', 'Berhasil logout!');
        }

        return redirect('/');
    }
}