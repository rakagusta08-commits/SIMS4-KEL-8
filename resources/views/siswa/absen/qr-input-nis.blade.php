<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Absen QR - SIM SEKOLAH</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    
    <style>
        body { 
            background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%); 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            font-family: 'Segoe UI', sans-serif; 
        }
        .card-scan { 
            border: none; 
            border-radius: 24px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.2); 
            overflow: hidden;
        }
        /* Style agar kamera tidak hitam dan responsif */
        #reader {
            width: 100%;
            border-radius: 15px;
            overflow: hidden;
            border: none !important;
            background: #000;
        }
        #reader video {
            object-fit: cover !important;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card card-scan">
                <div class="card-body p-4 text-center">
                    <h4 class="fw-bold mb-2">Scan QR Absensi</h4>
                    <p class="text-muted mb-3">Kelas: <strong>{{ $kelas }}</strong></p>

                    <div id="reader" class="mb-3"></div>

                    @if(isset($error))
                        <div class="alert alert-danger small mb-3">
                            {{ $error }}
                        </div>
                    @endif

                    <form id="form-absen" action="{{ route('siswa.absen.qr.scan', $token) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" 
                                   id="nis_input"
                                   name="nis" 
                                   class="form-control form-control-lg text-center fw-bold" 
                                   placeholder="Hasil Scan / Ketik NIS" 
                                   required 
                                   inputmode="numeric">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold py-3">
                            <i class="fas fa-check-circle me-2"></i> Catat Kehadiran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi yang dijalankan saat QR terdeteksi
    function onScanSuccess(decodedText, decodedResult) {
        // Isi input NIS dengan hasil scan
        document.getElementById('nis_input').value = decodedText;
        
        // Beri feedback suara/getar (opsional)
        if (navigator.vibrate) navigator.vibrate(100);

        // Langsung submit form otomatis
        document.getElementById('form-absen').submit();
        
        // Berhenti scan agar tidak submit berkali-kali
        html5QrCode.stop();
    }

    // Inisialisasi scanner dengan paksa kamera belakang
    const html5QrCode = new Html5Qrcode("reader");
    const config = { 
        fps: 10, 
        qrbox: { width: 250, height: 250 },
        aspectRatio: 1.0 
    };

    // Jalankan kamera dengan facingMode: environment (Kamera Belakang)
    html5QrCode.start(
        { facingMode: "environment" }, 
        config, 
        onScanSuccess
    ).catch(err => {
        console.error("Gagal akses kamera: ", err);
        alert("Pastikan izin kamera diberikan dan gunakan HTTPS");
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>