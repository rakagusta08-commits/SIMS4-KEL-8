<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use App\Models\Guru; 
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Tugas; 
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JadwalController; 
use App\Http\Controllers\TugasController; 
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AbsensiSiswaController;
use App\Http\Controllers\SiswaTodoController;
use App\Http\Controllers\SiswaProfilController;

/*
|--------------------------------------------------------------------------
| Web Routes - SIM SEKOLAH SMKN 4 BANDUNG PRO
|--------------------------------------------------------------------------
*/

// 🚀 1. HALAMAN UTAMA (PORTAL)
Route::get('/', function () {
    return view('welcome');
})->name('portal');

// 2. JALUR UMUM (LOGIN/LOGOUT)
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']); 
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 3. JALUR LOGIN SISWA
Route::get('/login/siswa', [LoginController::class, 'index'])->name('login.siswa');
Route::post('/login/siswa', [LoginController::class, 'login']);

// 4. JALUR LOGIN GURU
Route::get('/login/guru', [LoginController::class, 'indexGuru'])->name('login.guru');
Route::post('/login/guru', [LoginController::class, 'loginGuru'])->name('login.guru.post');


// ====================================================
// KELOMPOK RUTE KHUSUS GURU (DENGAN SISTEM ROLE)
// ====================================================
Route::middleware(['auth:guru'])->group(function () {
    
    // --- FITUR PILIH KELAS (PINTU MASUK RUANGAN) ---
    Route::get('/guru/pilih-kelas', [GuruController::class, 'pilihKelas'])->name('guru.pilih-kelas');
    Route::get('/guru/set-kelas/{id}', [GuruController::class, 'setKelas'])->name('guru.set-kelas');
    Route::get('/guru/keluar-kelas', [GuruController::class, 'keluarKelas'])->name('guru.keluar-kelas');

    // DASHBOARD: Terfilter otomatis berdasarkan kelas yang dipilih
    Route::get('/guru/dashboard', function () {
        $id_kelas = session('id_kelas_aktif');
        $nama_kelas = session('nama_kelas_aktif');

        if (!$id_kelas && strtolower(trim(Auth::guard('guru')->user()->role)) !== 'admin') {
            return redirect()->route('guru.pilih-kelas');
        }

        // --- LOGIKA ISOLASI DATA ---
        $querySiswa = Siswa::query();
        $queryTugas = Tugas::query();
        $queryJadwal = Jadwal::query();

        if ($nama_kelas) {
            $querySiswa->where('kelas', 'LIKE', '%'.$nama_kelas.'%');
            $queryTugas->where('kelas', 'LIKE', '%'.$nama_kelas.'%');
            $queryJadwal->where('kelas', 'LIKE', '%'.$nama_kelas.'%');
        }

        $jumlah_siswa = $querySiswa->count(); 
        $jumlah_guru  = Guru::count();
        $jumlah_kelas = Kelas::count();
        $jumlah_tugas = $queryTugas->count();
        
        // Statistik Absensi Real-Time
        $hadir = Absensi::where('tanggal', date('Y-m-d'))->where('status', 'Hadir')
                ->when($nama_kelas, function($q) use ($nama_kelas) {
                    return $q->whereHas('siswa', function($s) use ($nama_kelas) {
                        $s->where('kelas', 'LIKE', '%'.$nama_kelas.'%');
                    });
                })->count();

        $sakit = Absensi::where('tanggal', date('Y-m-d'))->where('status', 'Sakit')
                ->when($nama_kelas, function($q) use ($nama_kelas) {
                    return $q->whereHas('siswa', function($s) use ($nama_kelas) {
                        $s->where('kelas', 'LIKE', '%'.$nama_kelas.'%');
                    });
                })->count();

        $izin  = Absensi::where('tanggal', date('Y-m-d'))->where('status', 'Izin')
                ->when($nama_kelas, function($q) use ($nama_kelas) {
                    return $q->whereHas('siswa', function($s) use ($nama_kelas) {
                        $s->where('kelas', 'LIKE', '%'.$nama_kelas.'%');
                    });
                })->count();

        $alpa  = Absensi::where('tanggal', date('Y-m-d'))->where('status', 'Alpa')
                ->when($nama_kelas, function($q) use ($nama_kelas) {
                    return $q->whereHas('siswa', function($s) use ($nama_kelas) {
                        $s->where('kelas', 'LIKE', '%'.$nama_kelas.'%');
                    });
                })->count();

        $tugas_terbaru = $queryTugas->latest()->take(5)->get();
        $jadwal_hari_ini = $queryJadwal->get();

        return view('guru.dashboard', compact(
            'jumlah_siswa', 'jumlah_guru', 'jumlah_kelas', 'jumlah_tugas',
            'hadir', 'sakit', 'izin', 'alpa', 
            'tugas_terbaru', 'jadwal_hari_ini'
        ));
    })->name('guru.dashboard');


    // 👑 BLOK 1: KHUSUS ADMIN
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/guru/siswa', [SiswaController::class, 'index'])->name('siswa.index');
        Route::get('/guru/siswa/tambah', [SiswaController::class, 'create'])->name('siswa.create');
        Route::post('/guru/siswa/simpan', [SiswaController::class, 'store'])->name('siswa.store');
        Route::get('/guru/siswa/edit/{id}', [SiswaController::class, 'edit'])->name('siswa.edit');
        Route::put('/guru/siswa/update/{id}', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('/guru/siswa/hapus/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

        Route::get('/guru/data-guru', [GuruController::class, 'index'])->name('guru.index');
        Route::get('/guru/data-guru/tambah', [GuruController::class, 'create'])->name('guru.create');
        Route::post('/guru/data-guru/simpan', [GuruController::class, 'store'])->name('guru.store');
        Route::get('/guru/data-guru/edit/{id}', [GuruController::class, 'edit'])->name('guru.edit');
        Route::put('/guru/data-guru/update/{id}', [GuruController::class, 'update'])->name('guru.update');
        Route::delete('/guru/data-guru/hapus/{id}', [GuruController::class, 'destroy'])->name('guru.destroy');

        Route::get('/guru/data-kelas', [KelasController::class, 'index'])->name('kelas.index');
        Route::get('/guru/data-kelas/tambah', [KelasController::class, 'create'])->name('kelas.create');
        Route::post('/guru/data-kelas/simpan', [KelasController::class, 'store'])->name('kelas.store');
        Route::get('/guru/data-kelas/edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');
        Route::put('/guru/data-kelas/update/{id}', [KelasController::class, 'update'])->name('kelas.update');
        Route::delete('/guru/data-kelas/hapus/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

        Route::get('/guru/laporan-siswa/print', [SiswaController::class, 'printLaporan'])->name('laporan.siswa');
        Route::get('/guru/laporan-guru/print', [GuruController::class, 'printLaporan'])->name('laporan.guru');
    });

    // 👨‍🏫 BLOK 2: GURU MAPEL & ADMIN
    Route::middleware(['role:admin,guru_mapel', 'cek.kelas'])->group(function () {
        Route::resource('/guru/jadwal', JadwalController::class)->except(['show']);
        Route::resource('/guru/tugas', TugasController::class)->except(['show']);
        Route::get('/guru/tugas/koreksi/{id}', [TugasController::class, 'koreksi'])->name('tugas.koreksi');
        Route::post('/guru/tugas/nilai/{id}', [TugasController::class, 'simpanNilai'])->name('tugas.nilai');
    });

    // 📋 BLOK 3: WALI KELAS, GURU MAPEL & ADMIN
    Route::middleware(['role:admin,wali_kelas,guru_mapel', 'cek.kelas'])->group(function () {
        Route::get('/guru/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::get('/guru/absensi/input/{kelas_id}', [AbsensiController::class, 'input'])->name('absensi.input');
        Route::post('/guru/absensi/simpan', [AbsensiController::class, 'simpan'])->name('absensi.store');
        Route::get('/guru/absensi/rekap/{kelas_id}', [AbsensiController::class, 'rekap'])->name('absensi.rekap');
        Route::post('/guru/absensi/qr', [AbsensiController::class, 'storeQR'])->name('absensi.storeQR');
        
        // 🎯 QR CODE FEATURES
        Route::get('/guru/absensi/{id}/qr', [AbsensiController::class, 'showQR'])->name('absensi.showQR');
        Route::get('/guru/absensi/{id}/qr/download', [AbsensiController::class, 'downloadQR'])->name('absensi.downloadQR');
        Route::post('/guru/absensi/qr/bulk-generate', [AbsensiController::class, 'bulkGenerateQRCodes'])->name('absensi.bulkGenerateQR');
        Route::get('/guru/absensi/generate-qr/{kelas_id}', [AbsensiController::class, 'generateQRSession'])->name('absensi.qr.generate');
    });
    
    // 🎯 API GENERATE QR 
    Route::middleware('role:admin,wali_kelas,guru_mapel')->group(function () {
        Route::post('/guru/absensi/generateQR', [AbsensiController::class, 'generateQR'])->name('absensi.generateQR');
    });
});


// ====================================================
// KELOMPOK RUTE KHUSUS SISWA (WAJIB LOGIN)
// ====================================================
Route::middleware(['auth:siswa'])->group(function () {
    Route::get('/siswa/dashboard', function () { return view('siswa.dashboard'); })->name('siswa.dashboard');
    
    Route::get('/siswa/profil', function () {
        $siswa = Auth::guard('siswa')->user();
        return view('siswa.profil', compact('siswa'));
    })->name('siswa.profil');

    Route::get('/siswa/jadwal', [JadwalController::class, 'siswaIndex'])->name('siswa.jadwal');
    Route::get('/siswa/tugas', [TugasController::class, 'tugasSiswa'])->name('siswa.tugas');
    Route::post('/siswa/tugas/kumpul/{id}', [TugasController::class, 'kumpulTugas'])->name('siswa.tugas.kumpul');

    Route::get('/siswa/absensi', [AbsensiSiswaController::class, 'index'])->name('siswa.absensi.index');
    Route::post('/siswa/absensi', [AbsensiSiswaController::class, 'store'])->name('siswa.absensi.store');

    Route::get('/siswa/profil/edit', [SiswaProfilController::class, 'edit'])->name('siswa.profil.edit');
    Route::put('/siswa/profil/update', [SiswaProfilController::class, 'update'])->name('siswa.profil.update');

    Route::resource('/siswa/todo', SiswaTodoController::class, ['as' => 'siswa'])->except(['show']);
    Route::post('/siswa/todo/{id}/complete', [SiswaTodoController::class, 'complete'])->name('siswa.todo.complete');
    Route::post('/siswa/todo/{id}/uncomplete', [SiswaTodoController::class, 'uncomplete'])->name('siswa.todo.uncomplete');
    Route::delete('/siswa/todo/clear-completed', [SiswaTodoController::class, 'clearCompleted'])->name('siswa.todo.clearCompleted');
});


// ====================================================
// RUTE PUBLIK: QR ATTENDANCE SCANNING (TANPA LOGIN)
// ====================================================
// 🚀 Rute ini dikeluarkan dari auth:siswa agar HP yang belum login bisa langsung scan
Route::match(['get', 'post'], '/siswa/absen/qr/{token}', [AbsensiController::class, 'prosesScanQR'])->name('siswa.absen.qr.scan');

Route::get('/attendance/qr/{token}', [AbsensiController::class, 'showPublicQRScanner'])->name('attendance.scanQR');
Route::post('/attendance/qr/submit', [AbsensiController::class, 'submitPublicQRAttendance'])->name('attendance.submitQR');