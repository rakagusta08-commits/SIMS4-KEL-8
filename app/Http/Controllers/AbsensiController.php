<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Absensi;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AbsensiController extends Controller
{
    // ==========================================
    // 1. BAGIAN GURU: ABSENSI MANUAL
    // ==========================================
    public function index()
    {
        $user = Auth::guard('guru')->user();

        if ($user->role == 'wali_kelas' && $user->id_kelas_wali) {
            return redirect()->route('absensi.input', $user->id_kelas_wali);
        }

        if ($user->role == 'guru_mapel') {
            if (session('id_kelas_aktif')) {
                return redirect()->route('absensi.input', session('id_kelas_aktif'));
            } else {
                return redirect()->route('guru.pilih-kelas')->with('error', 'Akses Terkunci! Pilih kelas terlebih dahulu ya.');
            }
        }

        $data_kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        
        foreach ($data_kelas as $kelas) {
            $kelas->siswa_count = Siswa::where('kelas', 'LIKE', '%' . $kelas->nama_kelas . '%')->count();
            
            $kelas->hadir_hari_ini = Absensi::where('kelas_id', $kelas->id)
                ->where('tanggal', Carbon::today())
                ->where('status', 'Hadir')
                ->count();
        }
        
        return view('guru.absensi.index', compact('data_kelas'));
    }

    public function input($kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        $user = Auth::guard('guru')->user();
        
        if ($user->role == 'guru_mapel' && session('id_kelas_aktif') != $kelas_id) {
            return redirect()->route('guru.dashboard')->with('error', 'Akses ditolak!');
        }
        
        $data_siswa = Siswa::where('kelas', 'LIKE', '%'.$kelas->nama_kelas.'%')->orderBy('nama_siswa', 'ASC')->get(); 
        $absen_hari_ini = Absensi::where('tanggal', Carbon::today())->where('kelas_id', $kelas_id)->get()->keyBy('nis'); 
        
        $tanggal = Carbon::now()->translatedFormat('d F Y'); 
        $sudah_absen = $absen_hari_ini->isNotEmpty();

        return view('guru.absensi.input', compact('kelas', 'data_siswa', 'tanggal', 'sudah_absen', 'absen_hari_ini'));
    }

    public function simpan(Request $request)
    {
        $request->validate(['status' => 'required|array', 'kelas_id' => 'required']);

        foreach ($request->status as $nis => $status_absen) {
            Absensi::updateOrCreate(
                ['nis' => $nis, 'tanggal' => Carbon::today()],
                ['kelas_id' => $request->kelas_id, 'status' => $status_absen]
            );
        }
        return redirect()->back()->with('success', 'Data absensi manual berhasil diamankan!');
    }

    public function rekap($kelas_id, Request $request)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        
        $tanggal = $request->has('tanggal') 
            ? Carbon::createFromFormat('Y-m-d', $request->tanggal) 
            : Carbon::today();
        
        $data_absensi = Absensi::with('siswa')
            ->where('kelas_id', $kelas_id)
            ->where('tanggal', $tanggal->format('Y-m-d'))
            ->get();
        
        $absensi = $data_absensi->keyBy('nis');
        
        $siswa_kelas = Siswa::where('kelas', 'LIKE', '%' . $kelas->nama_kelas . '%')
            ->orderBy('nama_siswa')
            ->get();
        
        $hadir = $data_absensi->where('status', 'Hadir')->count();
        $sakit = $data_absensi->where('status', 'Sakit')->count();
        $izin = $data_absensi->where('status', 'Izin')->count();
        $alpa = $data_absensi->where('status', 'Alpa')->count();
        
        return view('guru.absensi.rekap', compact('kelas', 'data_absensi', 'tanggal', 'absensi', 'siswa_kelas', 'hadir', 'sakit', 'izin', 'alpa'));
    }

    // ==========================================
    // 2. BAGIAN GURU: GENERATOR QR CODE
    // ==========================================
    public function generateQRSession($kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        
        $token = \Illuminate\Support\Str::random(32);
        Cache::put('qr_absen_' . $token, $kelas->id, now()->addMinutes(60));

        // FIX NGROK: Ambil Host (ngrok/https) dari browser langsung, hindari http 172.x
        $host = request()->getSchemeAndHttpHost();
        $url_scan = $host . '/siswa/absen/qr/' . $token;

        $qr_image = QrCode::size(400)
                        ->margin(2)
                        ->format('svg')
                        ->generate($url_scan);

        return view('guru.absensi.generate-qr', compact('kelas', 'qr_image'));
    }

    public function generateQR(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);

        $token = \Illuminate\Support\Str::random(32);
        Cache::put('qr_absen_' . $token, $kelas->id, now()->addMinutes(30));

        // FIX NGROK: Ambil Host dari browser
        $host = request()->getSchemeAndHttpHost();
        $qr_link = $host . '/siswa/absen/qr/' . $token;

        $qr_svg = QrCode::size(300)
                        ->margin(2)
                        ->format('svg')
                        ->generate($qr_link);

        return response()->json([
            'success' => true,
            'qr_link' => $qr_link,
            'qr_svg'  => (string) $qr_svg,
            'message' => 'QR Code berhasil dibuat'
        ]);
    }

    // ==========================================
    // 3. BAGIAN SISWA: SCAN & PROSES
    // ==========================================
    public function prosesScanQR(Request $request, $token)
    {
        // 1. Validasi token
        $kelas_id = Cache::get('qr_absen_' . $token);
        if (!$kelas_id) {
            return view('siswa.absen.qr-result', [
                'success' => false,
                'message' => 'QR Code tidak valid atau sudah kadaluarsa!'
            ]);
        }
        
        $kelas = Kelas::find($kelas_id);
        if (!$kelas) {
            return view('siswa.absen.qr-result', [
                'success' => false,
                'message' => 'Data kelas tidak ditemukan!'
            ]);
        }

        // 2. Identifikasi Siswa (HAPUS LOGIKA COOKIE AGAR TIDAK TERTUKAR)
        $siswa_aktif = Auth::guard('siswa')->user();
        $siswa = null;

        if ($siswa_aktif) {
            // Jika siswa sudah login, WAJIB gunakan data siswa tersebut
            $siswa = $siswa_aktif;
        } else {
            // Jika belum login, cek apakah dia baru saja mengisi form NIS
            if ($request->filled('nis')) {
                $siswa = Siswa::where('nis', $request->nis)->first();
                
                if (!$siswa) {
                    return view('siswa.absen.qr-input-nis', [
                        'token' => $token,
                        'kelas' => $kelas->nama_kelas,
                        'error' => 'NIS tidak ditemukan! Cek lagi NIS Anda.',
                    ]);
                }
            } else {
                // Jika belum login dan belum input NIS, arahkan ke form input
                return view('siswa.absen.qr-input-nis', [
                    'token' => $token,
                    'kelas' => $kelas->nama_kelas,
                ]);
            }
        }

        // 3. Validasi kelas siswa cocok dengan kelas QR
        $kelas_qr    = strtolower(trim(preg_replace('/\s+/', ' ', $kelas->nama_kelas)));
        $kelas_siswa = strtolower(trim(preg_replace('/\s+/', ' ', $siswa->kelas)));
        if ($kelas_qr !== $kelas_siswa && !str_contains($kelas_qr, $kelas_siswa) && !str_contains($kelas_siswa, $kelas_qr)) {
            return view('siswa.absen.qr-result', [
                'success' => false,
                'message' => 'QR ini untuk kelas "' . $kelas->nama_kelas . '", bukan kelas Anda (' . $siswa->kelas . ').'
            ]);
        }

        // 4. Cek sudah absen?
        $sudah_absen = Absensi::where('nis', $siswa->nis)
                            ->where('kelas_id', $kelas_id)
                            ->where('tanggal', Carbon::today())
                            ->first();
                            
        if ($sudah_absen) {
            return response()->view('siswa.absen.qr-result', [
                'success' => true,
                'siswa'   => $siswa,
                'kelas'   => $kelas,
                'message' => 'Anda sudah tercatat HADIR hari ini!',
                'duplicate' => true,
            ]);
        }

        // 5. Simpan absensi
        Absensi::create([
            'nis'      => $siswa->nis,
            'kelas_id' => $kelas_id,
            'tanggal'  => Carbon::today(),
            'status'   => 'Hadir',
        ]);

        // 6. Tampil halaman success (Tanpa cookie)
        return response()->view('siswa.absen.qr-result', [
            'success' => true,
            'siswa'   => $siswa,
            'kelas'   => $kelas,
            'message' => 'BERHASIL! Anda tercatat HADIR hari ini.',
        ]);
    }
}