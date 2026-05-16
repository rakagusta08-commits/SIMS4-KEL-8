@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="container py-5 animate__animated animate__fadeIn">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-2"><i class="fas fa-qrcode me-2" style="color: #6366f1;"></i>Sistem Absensi QR Code</h2>
            <p class="text-muted mb-0">Guru generate QR Code, siswa scan untuk absen otomatis</p>
        </div>
        <div class="text-end">
            <span class="badge" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); padding: 12px 20px; border-radius: 20px; font-size: 0.95rem;">
                <i class="fas fa-calendar-day me-2"></i> {{ date('d F Y') }}
            </span>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert border-0 shadow-sm mb-4 animate__animated animate__backInDown" style="border-radius: 15px; background: linear-gradient(135deg, #d1fae5, #a7f3d0); border-left: 5px solid #10b981; padding: 18px;">
            <i class="fas fa-check-circle me-2" style="color: #059669; font-size: 1.2rem;"></i> 
            <strong style="color: #059669;">{{ session('success') }}</strong>
        </div>
    @endif

    {{-- Grid Kelas --}}
    <div class="row g-4">
        @foreach($data_kelas as $kelas)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100 animate__animated animate__zoomIn" 
                 style="border-radius: 20px; transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1); overflow: hidden; background: white;">
                
                {{-- Card Header dengan Gradient --}}
                <div style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); padding: 25px; text-align: center; color: white; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -50%; right: -20%; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    <div style="position: relative; z-index: 1;">
                        <div class="mb-3">
                            <i class="fas fa-chalkboard fa-3x" style="opacity: 0.9;"></i>
                        </div>
                        <h4 class="fw-bold mb-1">{{ $kelas->nama_kelas }}</h4>
                        <p class="mb-0" style="opacity: 0.95; font-size: 0.9rem;">
                            <i class="fas fa-door-open me-1"></i> {{ $kelas->ruangan ?? 'Ruang -' }}
                        </p>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="card-body p-4">
                    {{-- Info Jumlah Siswa --}}
                    <div class="row mb-4">
                        <div class="col-6">
                            <div style="background: linear-gradient(135deg, #e0e7ff, #f0f4ff); padding: 15px; border-radius: 15px; text-align: center;">
                                <h4 class="fw-bold text-primary mb-1" style="font-size: 1.8rem;">{{ $kelas->siswa_count ?? 0 }}</h4>
                                <small class="text-muted">Total Siswa</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="background: linear-gradient(135deg, #fef3c7, #fef08a); padding: 15px; border-radius: 15px; text-align: center;">
                                <h4 class="fw-bold text-warning mb-1" style="font-size: 1.8rem;">{{ $kelas->hadir_hari_ini ?? 0 }}</h4>
                                <small class="text-muted">Hadir</small>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Action --}}
                    <div class="d-grid gap-2">
                        {{-- Tombol Generate QR --}}
                        <button class="btn fw-bold py-3 rounded-pill" 
                                style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none; transition: all 0.3s ease; font-size: 0.95rem;"
                                data-bs-toggle="modal" data-bs-target="#qrGeneratorModal" 
                                data-kelas-id="{{ $kelas->id }}" data-kelas-name="{{ $kelas->nama_kelas }}" 
                                onclick="initQRGenerator(this)">
                            <i class="fas fa-qrcode me-2"></i> Generate QR Absensi
                        </button>

                        {{-- Tombol Input Manual (Backup) --}}
                        <a href="{{ route('absensi.input', $kelas->id) }}" class="btn fw-bold py-3 rounded-pill" 
                           style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border: none; transition: all 0.3s ease; font-size: 0.95rem;">
                            <i class="fas fa-keyboard me-2"></i> Input Manual
                        </a>

                        {{-- Tombol Lihat Rekap --}}
                        <a href="{{ route('absensi.rekap', $kelas->id) }}" class="btn btn-outline-primary fw-bold py-2 rounded-pill" style="border-width: 2px;">
                            <i class="fas fa-history me-1"></i> Rekap Hari Ini
                        </a>
                    </div>
                </div>

                {{-- Card Footer --}}
                <div class="card-footer border-0 py-3 px-4" style="background: #f8f9ff; text-align: center;">
                    <small class="text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 1px; text-transform: uppercase;">
                        SMKN 4 BANDUNG
                    </small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Modal QR Generator untuk Guru --}}
<div class="modal fade" id="qrGeneratorModal" tabindex="-1" aria-labelledby="qrGeneratorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            {{-- Modal Header --}}
            <div style="background: linear-gradient(135deg, #f59e0b, #d97706); padding: 25px; color: white;">
                <h5 class="modal-title fw-bold" id="qrGeneratorLabel">
                    <i class="fas fa-qrcode me-2"></i> Generate QR Code Absensi
                </h5>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body p-4 text-center">
                <div class="alert alert-info border-0 rounded-3 mb-4" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e40af;">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Instruksi:</strong> Klik tombol "Generate QR" untuk membuat QR Code absensi. Siswa dapat scan QR ini dengan HP mereka untuk absen otomatis.
                </div>

                {{-- QR Scanner Video --}}
                <div id="qrScannerContainer" style="display: none; margin: 20px 0;">
                    <video id="qrScannerVideo" style="width: 100%; max-width: 400px; border-radius: 15px; border: 3px solid #6366f1;"></video>
                    <button type="button" class="btn btn-danger btn-sm mt-2 rounded-pill px-4 fw-bold" onclick="stopQRScanner()">
                        <i class="fas fa-stop me-2"></i> Hentikan Scanner
                    </button>
                </div>

                {{-- Display QR Code --}}
                <div id="qrCodeContainer" style="display: none; margin: 30px 0;">
                    <p class="text-muted small mb-3">✅ QR Code Absensi (Berlaku 30 menit)</p>
                    <div id="qrCode" style="background: white; padding: 20px; border-radius: 15px; display: inline-block; box-shadow: 0 10px 30px rgba(0,0,0,0.1);"></div>
                    <p class="text-muted small mt-3">Link Alternatif (Jika QR tidak terbaca):</p>
                    <input type="text" id="qrLink" class="form-control form-control-sm rounded-3" readonly style="background: #f3f4f6; border: 2px solid #e5e7eb;">
                </div>

                {{-- Loading State --}}
                <div id="qrLoading" class="text-center py-5">
                    <p class="text-muted">Siap untuk membuat QR Code...</p>
                </div>

                {{-- QR Aktif Info --}}
                <div id="qrActiveInfo" style="display: none;">
                    <div class="alert alert-success border-0 rounded-3" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46;">
                        <i class="fas fa-check-circle me-2"></i> QR Code sudah aktif! Siswa dapat mulai scan.
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer border-0 p-4" style="background: #f8f9ff;">
                <button type="button" class="btn btn-secondary fw-bold rounded-pill px-4 py-2" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="button" class="btn fw-bold rounded-pill px-4 py-2" 
                        style="background: linear-gradient(135deg, #10b981, #059669); color: white;" 
                        onclick="startQRScanner()" id="scanQRBtn">
                    <i class="fas fa-camera me-2"></i> Scan QR
                </button>
                <button type="button" class="btn fw-bold rounded-pill px-4 py-2" 
                        style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white;" id="generateQRBtn" onclick="generateQRCode()">
                    <i class="fas fa-sync me-2"></i> Generate QR Code
                </button>
            </div>
        </div>
    </div>
</div>


<style>
    /* Hover Effect untuk Card */
    .card {
        position: relative;
    }
    
    .card:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 25px 50px rgba(99, 102, 241, 0.15) !important; 
    }

    .btn:hover {
        transform: scale(1.02);
    }

    /* Button Hover Animation */
    .btn {
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn:hover::before {
        width: 300px;
        height: 300px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>

<script>
    let currentKelasId = null;
    let currentKelasName = null;

    function initQRGenerator(button) {
        currentKelasId = button.getAttribute('data-kelas-id');
        currentKelasName = button.getAttribute('data-kelas-name');
        
        // Reset modal content
        document.getElementById('qrLoading').style.display = 'block';
        document.getElementById('qrCodeContainer').style.display = 'none';
        document.getElementById('qrActiveInfo').style.display = 'none';
        document.getElementById('generateQRBtn').disabled = false;
        document.getElementById('generateQRBtn').innerHTML = '<i class="fas fa-sync me-2"></i> Generate QR Code';
    }

    function generateQRCode() {
        if (!currentKelasId) {
            alert('Kelas tidak terdeteksi');
            return;
        }

        const generateBtn = document.getElementById('generateQRBtn');
        generateBtn.disabled = true;
        generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Generating...';

        fetch('{{ route("absensi.generateQR") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                kelas_id: currentKelasId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tampilkan SVG QR Code langsung dari response backend
                const qrContainer = document.getElementById('qrCode');
                qrContainer.innerHTML = data.qr_svg;  // Masukkan SVG langsung
                
                // Set link alternatif
                document.getElementById('qrLink').value = data.qr_link;
                
                // Hide loading dan show result
                document.getElementById('qrLoading').style.display = 'none';
                document.getElementById('qrCodeContainer').style.display = 'block';
                document.getElementById('qrActiveInfo').style.display = 'block';

                generateBtn.disabled = false;
                generateBtn.innerHTML = '<i class="fas fa-sync me-2"></i> Generate QR Code Baru';
                
                console.log('QR Code generated successfully:', data);
            } else {
                alert('Error: ' + (data.message || 'Gagal generate QR'));
                generateBtn.disabled = false;
                generateBtn.innerHTML = '<i class="fas fa-sync me-2"></i> Generate QR Code';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat generate QR: ' + error.message);
            generateBtn.disabled = false;
            generateBtn.innerHTML = '<i class="fas fa-sync me-2"></i> Generate QR Code';
        });
    }

    // 🎯 FITUR SCAN QR UNTUK GURU
    let cameraStream = null;
    let scanActive = false;

    function startQRScanner() {
        scanActive = true;
        const video = document.getElementById('qrScannerVideo');
        
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                .then(function(stream) {
                    cameraStream = stream;
                    video.srcObject = stream;
                    video.onloadedmetadata = function() {
                        scanQRCode(video);
                    };
                })
                .catch(function(error) {
                    alert('Tidak bisa akses kamera: ' + error.message);
                    scanActive = false;
                });
        } else {
            alert('Browser tidak support camera access');
        }
    }

    function scanQRCode(video) {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        const scanInterval = setInterval(function() {
            if (!scanActive) {
                clearInterval(scanInterval);
                return;
            }

            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            
            if (typeof jsQR !== 'undefined') {
                const code = jsQR(imageData.data, imageData.width, imageData.height);
                
                if (code) {
                    console.log('QR Code detected:', code.data);
                    stopQRScanner();
                    alert('QR Terdeteksi: ' + code.data);
                }
            }
        }, 500);
    }

    function stopQRScanner() {
        scanActive = false;
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
        }
        document.getElementById('qrScannerVideo').srcObject = null;
    }
</script>
@endsection