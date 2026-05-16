<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR - Sistem Absensi SMKN 4 Bandung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsqr@0.01.0/dist/jsQR.css">
    
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #8b5cf6;
            --success: #10b981;
            --danger: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container-qr {
            width: 100%;
            max-width: 500px;
            margin: 20px;
        }

        .card-qr {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: none;
        }

        .header-qr {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header-qr::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .header-qr h2 {
            position: relative;
            z-index: 1;
            margin: 0;
            font-weight: 700;
            font-size: 1.8rem;
        }

        .header-qr p {
            position: relative;
            z-index: 1;
            margin-top: 10px;
            opacity: 0.95;
            font-size: 0.95rem;
        }

        .badge-qr {
            display: inline-block;
            background: rgba(255,255,255,0.3);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-top: 12px;
            backdrop-filter: blur(10px);
        }

        .scanner-container {
            background: #1a1a1a;
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            margin: 20px;
            aspect-ratio: 1;
        }

        #qrVideo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #canvas {
            display: none;
        }

        .scanning-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            aspect-ratio: 1;
            border: 3px solid var(--success);
            border-radius: 15px;
            pointer-events: none;
            animation: pulse-scan 2s infinite;
        }

        @keyframes pulse-scan {
            0%, 100% {
                border-color: var(--success);
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.5);
            }
            50% {
                border-color: var(--primary);
                box-shadow: 0 0 40px rgba(99, 102, 241, 0.8);
            }
        }

        .form-section {
            padding: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.2);
            outline: none;
        }

        .input-group-text {
            background: #f3f4f6;
            border: 2px solid #e5e7eb;
            border-right: none;
            color: #666;
        }

        .input-group .form-control {
            border-left: none;
        }

        .alert-qr {
            border-radius: 12px;
            border: none;
            margin-bottom: 15px;
            padding: 15px;
        }

        .alert-success-qr {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            border-left: 5px solid var(--success);
        }

        .alert-danger-qr {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #7f1d1d;
            border-left: 5px solid var(--danger);
        }

        .alert-info-qr {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
            border-left: 5px solid #3b82f6;
        }

        .result-display {
            background: #f3f4f6;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            text-align: center;
            display: none;
        }

        .result-display h5 {
            margin: 0;
            color: #666;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .result-display .nis-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-top: 8px;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
            color: white;
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .text-center-custom {
            text-align: center;
            color: #999;
            font-size: 0.9rem;
            margin-top: 15px;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
            vertical-align: middle;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .icon-large {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .timer {
            display: inline-block;
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container-qr animate__animated animate__fadeIn">
        <div class="card-qr">
            {{-- Header --}}
            <div class="header-qr">
                <h2><i class="fas fa-qrcode me-2"></i>Absensi QR Code</h2>
                <p>Scan QR atau input NIS Anda untuk absensi</p>
                <div class="badge-qr">
                    <i class="fas fa-chalkboard me-2"></i>{{ $kelas }}
                    <span class="timer">Berlaku <span id="countdown">30:00</span></span>
                </div>
            </div>

            {{-- Alert Messages --}}
            <div class="form-section">
                <div id="alertContainer"></div>
            </div>

            {{-- Scanner Section --}}
            <div class="scanner-container animate__animated animate__zoomIn">
                <video id="qrVideo" autoplay playsinline muted></video>
                <canvas id="canvas"></canvas>
                <div class="scanning-overlay"></div>
            </div>

            {{-- Form Section --}}
            <div class="form-section">
                {{-- Info Text --}}
                <div class="alert alert-info-qr alert-qr">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>🔍 Tips:</strong> Arahkan kamera ke QR Code. Atau input NIS secara manual di bawah.
                </div>

                {{-- Result Display --}}
                <div class="result-display" id="resultDisplay">
                    <h5>NIS Terdeteksi</h5>
                    <div class="nis-value" id="resultNIS">-</div>
                </div>

                {{-- Form Input --}}
                <form id="attendanceForm" onsubmit="submitAttendance(event)">
                    <div class="mb-3">
                        <label for="nisInput" class="form-label">
                            <i class="fas fa-id-card me-2" style="color: var(--primary);"></i>NIS Siswa
                        </label>
                        <input type="text" class="form-control form-control-lg" id="nisInput" 
                               name="nis" placeholder="Scan atau ketik NIS Anda" required
                               autocomplete="off">
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i class="fas fa-check-circle me-2"></i>Catat Absensi Saya
                    </button>
                </form>

                <p class="text-center-custom">
                    <i class="fas fa-lock me-1"></i>Data Anda dilindungi dengan enkripsi SSL
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsqr@0.01.0/dist/jsQR.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const token = "{{ $token }}";
        const expiresAt = new Date("{{ $expires_at }}");
        let scanning = false;
        let lastDetectedQR = null;

        // Countdown Timer
        function updateCountdown() {
            const now = new Date();
            const diff = expiresAt - now;

            if (diff <= 0) {
                document.getElementById('countdown').textContent = '00:00';
                disableForm('QR Code sudah kadaluarsa');
                return;
            }

            const minutes = Math.floor(diff / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            document.getElementById('countdown').textContent = 
                `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            setTimeout(updateCountdown, 1000);
        }

        // Start Camera
        async function startCamera() {
            try {
                const constraints = {
                    video: {
                        facingMode: 'environment',
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    },
                    audio: false
                };

                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                const video = document.getElementById('qrVideo');
                video.srcObject = stream;

                setTimeout(() => {
                    scanQRCode(video);
                }, 500);
            } catch (err) {
                showAlert('Tidak dapat mengakses kamera. Silakan periksa izin kamera.', 'danger');
                console.error('Kamera error:', err);
            }
        }

        // Scan QR Code
        function scanQRCode(video) {
            const canvas = document.getElementById('canvas');
            const ctx = canvas.getContext('2d');

            function scan() {
                if (video.readyState === video.HAVE_ENOUGH_DATA && !scanning) {
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const code = jsQR(imageData.data, imageData.width, imageData.height);

                    if (code && code.data !== lastDetectedQR) {
                        lastDetectedQR = code.data;
                        
                        // Extract NIS dari QR
                        const nis = code.data.split('nis=')[1] || code.data;
                        document.getElementById('nisInput').value = nis;
                        
                        // Show result
                        document.getElementById('resultNIS').textContent = nis;
                        document.getElementById('resultDisplay').style.display = 'block';

                        // Auto submit
                        showAlert('✅ QR terdeteksi! Memproses absensi...', 'success');
                    }
                }
                requestAnimationFrame(scan);
            }
            scan();
        }

        // Submit Attendance
        async function submitAttendance(event) {
            event.preventDefault();

            const nis = document.getElementById('nisInput').value.trim();
            if (!nis) {
                showAlert('Masukkan atau scan NIS terlebih dahulu', 'danger');
                return;
            }

            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="loading-spinner"></span>Memproses...';

            try {
                const response = await fetch("{{ route('attendance.submitQR') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        token: token,
                        nis: nis
                    })
                });

                const data = await response.json();

                if (data.success) {
                    showAlert(data.message, 'success');
                    document.getElementById('nisInput').value = '';
                    document.getElementById('resultDisplay').style.display = 'none';
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showAlert(data.message, 'danger');
                }
            } catch (error) {
                showAlert('Terjadi kesalahan. Silakan coba lagi.', 'danger');
                console.error('Error:', error);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Catat Absensi Saya';
            }
        }

        // Show Alert
        function showAlert(message, type) {
            const container = document.getElementById('alertContainer');
            const alertClass = type === 'success' ? 'alert-success-qr' : 'alert-danger-qr';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

            const alert = document.createElement('div');
            alert.className = `alert-qr ${alertClass} animate__animated animate__slideInDown`;
            alert.innerHTML = `<i class="fas ${icon} me-2"></i>${message}`;

            container.innerHTML = '';
            container.appendChild(alert);

            if (type === 'success') {
                setTimeout(() => alert.remove(), 3000);
            }
        }

        // Disable Form
        function disableForm(message) {
            document.getElementById('nisInput').disabled = true;
            document.getElementById('submitBtn').disabled = true;
            showAlert(message, 'danger');
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            startCamera();
            updateCountdown();
        });
    </script>
</body>
</html>
[