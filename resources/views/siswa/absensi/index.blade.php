@extends('layouts.master')
@section('title', 'Absensi | SIM SEKOLAH')

@section('content')
<div class="container py-4">

    {{-- HEADER TANGGAL --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);">
        <div class="card-body p-4 text-white">
            <h4 class="fw-bold mb-1"><i class="fas fa-clipboard-check me-2"></i> Absensi Hari Ini</h4>
            <p class="mb-0 opacity-75">
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
            </p>
        </div>
    </div>

    {{-- ALERT --}}
    <div id="alertBox"></div>
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4">
            <i class="fas fa-times-circle me-1"></i> {{ session('error') }}
        </div>
    @endif

    {{-- === KONDISI 1: SUDAH ABSEN === --}}
    @if(isset($cek_absen) && $cek_absen)
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4 text-center">
                @php
                    $statusColor = [
                        'Hadir' => ['bg' => '#10b981', 'icon' => 'check-circle'],
                        'Sakit' => ['bg' => '#f59e0b', 'icon' => 'briefcase-medical'],
                        'Izin'  => ['bg' => '#3b82f6', 'icon' => 'envelope-open-text'],
                        'Alpa'  => ['bg' => '#ef4444', 'icon' => 'times-circle'],
                    ];
                    $s = $statusColor[$cek_absen->status] ?? ['bg' => '#64748b', 'icon' => 'question-circle'];
                @endphp
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                     style="width:80px;height:80px;background:{{ $s['bg'] }};">
                    <i class="fas fa-{{ $s['icon'] }} text-white fa-2x"></i>
                </div>
                <h5 class="fw-bold mb-1">Status Anda Hari Ini: {{ $cek_absen->status }}</h5>

                <div class="info-box p-3 bg-light rounded-3 mb-3">
                    <small class="text-muted d-block mb-2"><i class="far fa-calendar me-1"></i> Tanggal Absensi</small>
                    <p class="fw-bold mb-0">{{ \Carbon\Carbon::parse($cek_absen->tanggal)->locale('id')->translatedFormat('d F Y') }}</p>
                </div>

                @if($cek_absen->keterangan)
                <div class="info-box p-3 bg-light rounded-3 mb-3">
                    <small class="text-muted d-block mb-2"><i class="fas fa-sticky-note me-1"></i> Keterangan</small>
                    <p class="mb-0">{{ $cek_absen->keterangan }}</p>
                </div>
                @endif
                
                <div class="mt-4">
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-primary rounded-pill px-4 py-2">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>

    {{-- === KONDISI 2: BELUM ABSEN (HANYA SCAN QR) === --}}
    @else
        {{-- Alert Error --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                <strong>Error!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- INFORMASI SISWA --}}
        <div class="info-box p-3 bg-white shadow-sm rounded-4 mb-4 border border-light">
            <div class="row text-center">
                <div class="col-4 border-end">
                    <small class="text-muted d-block mb-1"><i class="fas fa-user"></i> Nama</small>
                    <span class="fw-bold text-truncate d-block" style="font-size: 0.9rem;">{{ $siswa->nama_siswa ?? $siswa->nama }}</span>
                </div>
                <div class="col-4 border-end">
                    <small class="text-muted d-block mb-1"><i class="fas fa-id-card"></i> NIS</small>
                    <span class="fw-bold" style="font-size: 0.9rem;">{{ $siswa->nis }}</span>
                </div>
                <div class="col-4">
                    <small class="text-muted d-block mb-1"><i class="fas fa-chalkboard"></i> Kelas</small>
                    <span class="fw-bold" style="font-size: 0.9rem;">{{ $siswa->kelas->nama ?? $siswa->kelas }}</span>
                </div>
            </div>
        </div>

        {{-- WADAH SCAN QR --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 text-center">
                <div class="mb-3">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-qrcode text-primary fa-2x"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-2">Scan QR dari Guru</h5>
                <p class="text-muted small mb-4">Arahkan kamera depan Anda ke QR Code yang ditampilkan oleh guru untuk absen Hadir otomatis.</p>
                
                <div id="geofence-status" class="mb-3"></div>
                
                <div id="reader" class="mx-auto overflow-hidden shadow-sm" style="width: 100%; max-width: 350px; border-radius: 16px; background: #000; border: 3px solid #e2e8f0; display: none;"></div>
            </div>
        </div>
    @endif

</div>

{{-- LIBRARY KAMERA: Hanya HTML5 QRCode --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- LOGIKA HTML5-QRCODE (KAMERA DEPAN) ---
    let html5QrCode;
    const readerElement = document.getElementById('reader');
    const geofenceStatus = document.getElementById('geofence-status');

    // --- KONFIGURASI GEOFENCING ---
    const schoolLat = -6.9200; // Ganti dengan latitude sekolah yang sebenarnya
    const schoolLng = 107.6046; // Ganti dengan longitude sekolah yang sebenarnya
    const MAX_DISTANCE = 50; // dalam meter

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3; // Radius bumi dalam meter
        const phi1 = lat1 * Math.PI/180;
        const phi2 = lat2 * Math.PI/180;
        const deltaPhi = (lat2-lat1) * Math.PI/180;
        const deltaLambda = (lon2-lon1) * Math.PI/180;

        const a = Math.sin(deltaPhi/2) * Math.sin(deltaPhi/2) +
                Math.cos(phi1) * Math.cos(phi2) *
                Math.sin(deltaLambda/2) * Math.sin(deltaLambda/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

        return R * c; 
    }

    function startQR() {
        if (!readerElement) return;
        
        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("reader");
        }
        
        html5QrCode.start(
            { facingMode: "user" }, 
            { fps: 10, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 },
            function(decodedText) {
                html5QrCode.stop(); 
                if (navigator.vibrate) navigator.vibrate(200);
                window.location.href = decodedText; 
            }
        ).catch(err => {
            console.error("Gagal menjalankan QR Scanner:", err);
            readerElement.style.display = 'block';
            readerElement.innerHTML = '<div class="p-4 text-white"><i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i><br><small>Gagal mengakses kamera.<br>Pastikan Anda mengizinkan akses kamera dan link berawalan HTTPS.</small></div>';
        });
    }

    // --- INISIALISASI LOKASI ---
    if (readerElement && geofenceStatus) {
        if ("geolocation" in navigator) {
            // Tampilkan loading text
            geofenceStatus.innerHTML = `
                <div class="alert alert-info text-center border-0 shadow-sm rounded-4">
                    <div class="spinner-border spinner-border-sm text-info mb-2" role="status"></div>
                    <br><strong class="text-info">Mengecek keamanan lokasi...</strong><br>
                    <small>Pastikan GPS Anda aktif untuk melakukan absensi.</small>
                </div>
            `;

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    
                    const distance = calculateDistance(schoolLat, schoolLng, userLat, userLng);
                    
                    if (distance <= MAX_DISTANCE) {
                        geofenceStatus.innerHTML = `
                            <div class="alert alert-success text-center border-0 shadow-sm rounded-4 py-2">
                                <i class="fas fa-check-circle me-1"></i> Lokasi terverifikasi (${Math.round(distance)}m).
                            </div>
                        `;
                        readerElement.style.display = 'block'; // Tampilkan kamera
                        startQR(); // Jalankan kamera
                    } else {
                        geofenceStatus.innerHTML = `
                            <div class="alert alert-danger text-center border-0 shadow-sm rounded-4">
                                <i class="fas fa-exclamation-triangle me-1 fa-lg mb-2"></i><br>
                                <strong>Akses Ditolak:</strong> Anda berada di luar radius sekolah (${Math.round(distance)}m).<br>
                                <small class="d-block mt-1 mb-3">Silakan ajukan Izin atau Sakit.</small>
                                <div>
                                    <a href="/siswa/sakit" class="btn btn-sm btn-danger fw-bold rounded-pill px-4 me-2">Sakit</a>
                                    <a href="/siswa/izin" class="btn btn-sm btn-warning text-dark fw-bold rounded-pill px-4">Izin</a>
                                </div>
                            </div>
                        `;
                    }
                },
                function(error) {
                    let errorMsg = "Akses lokasi ditolak atau gagal didapatkan. Silakan izinkan akses lokasi (GPS) di browser Anda.";
                    if (error.code == 1) errorMsg = "Akses lokasi ditolak oleh pengguna. Mohon izinkan lokasi untuk absensi.";
                    
                    geofenceStatus.innerHTML = `
                        <div class="alert alert-danger text-center border-0 shadow-sm rounded-4">
                            <i class="fas fa-map-marker-slash me-1 fa-lg mb-2"></i><br>
                            <strong>Gagal!</strong> ${errorMsg}
                        </div>
                    `;
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        } else {
            geofenceStatus.innerHTML = `
                <div class="alert alert-danger text-center border-0 shadow-sm rounded-4">
                    <i class="fas fa-times-circle me-1"></i> Browser Anda tidak mendukung Geolocation API.
                </div>
            `;
        }
    }
});
</script>
@endsection