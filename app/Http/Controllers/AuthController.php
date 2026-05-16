<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // --- MENAMPILKAN HALAMAN LOGIN ---

    public function loginGuru()
    {
        return view('auth.login-guru');
    }

    public function loginSiswa()
    {
        return view('auth.login-siswa');
    }

    // --- PROSES LOGIN GURU ---

    public function prosesLoginGuru(Request $request)
    {
        // Saya sesuaikan agar bisa menerima input 'nip' atau 'username'
        $request->validate([
            'username' => 'required', 
            'password' => 'required',
        ]);

        // Laravel akan mencoba mencocokkan inputan ke kolom 'nip' di database
        $credentials = [
            'nip'      => $request->username, 
            'password' => $request->password
        ];

        if (Auth::guard('guru')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/guru/dashboard')->with('success', 'Selamat Datang Bapak/Ibu Guru!');
        }

        return back()->with('error', 'Login Guru Gagal! Periksa NIP dan Password.');
    }

    // --- PROSES LOGIN SISWA ---

    public function prosesLoginSiswa(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Kita ambil input 'username' dari form, tapi kita tembak ke kolom 'nis' di database
        $credentials = [
            'nis'      => $request->username, 
            'password' => $request->password
        ];

        if (Auth::guard('siswa')->attempt($credentials)) {
            $request->session()->regenerate();
            // Khusus buat kamu Gus, redirectnya ke dashboard siswa
            return redirect()->intended('/siswa/dashboard')->with('success', 'Halo Guru, Selamat Belajar!');
        }

        return back()->with('error', 'Login Siswa Gagal! Periksa NIS dan Password.');
    }

    // --- LOGOUT ---

    public function logout(Request $request)
    {
        if (Auth::guard('guru')->check()) {
            Auth::guard('guru')->logout();
        } elseif (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil Keluar.');
    }
}