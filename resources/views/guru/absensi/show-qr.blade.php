@extends('layouts.master')

@section('title', 'QR Code Absensi | SIM SEKOLAH')

@section('content')
<style>
    .qr-container {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border-radius: 30px;
        padding: 40px;
        margin-bottom: 40px;
        color: white;
        box-shadow: 0 15px 30px rgba(99, 102, 241, 0.2);
    }

    .qr-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .qr-image {
        width: 100%;
        max-width: 350px;
        margin: 20px auto;
        border: 3px solid #e5e7eb;
        border-radius: 15px;
        padding: 15px;
        background: #f9fafb;
    }

    .info-section {
        background: #f0f4ff;
        border-left: 5px solid #6366f1;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
        text-align: left;
    }

    .badge-status {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 700;
        margin: 10px 5px;
    }

    .badge-hadir {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-sakit {
        background: #dbeafe;
        color: #0c4a6e;
    }

    .badge-izin {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-alpa {
        background: #fee2e2;
        color: #991b1b;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
    }

    .btn-action {
        padding: 12px 30px;
        border-radius: 15px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: 0.3s ease;
        font-size: 1rem;
    }

    .btn-download {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .btn-download:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }

    .btn-back {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-back:hover {
        background: #d1d5db;
    }

    .btn-print {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
    }

    .btn-print:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
    }
</style>

<div style="padding: 40px;">
    <div class="qr-container">
        <div>
            <h1 class="fw-bold mb-1">QR Code Absensi 📱</h1>
            <p class="opacity-75 fs-5 mb-0">Data terintegrasi dengan database otomatis</p>
        </div>
    </div>

    <div class="qr-card">
        {{-- Detail Siswa --}}
        <div style="margin-bottom: 30px;">
            <h5 class="fw-bold text-dark mb-3">
                <i class="fas fa-user me-2" style="color: #6366f1;"></i>
                Informasi Siswa
            </h5>
            <p style="font-size: 1.3rem; font-weight: 800; color: #1e293b; margin-bottom: 10px;">
                {{ $absensi->siswa->nama_siswa ?? 'N/A' }}
            </p>
            <p style="font-size: 1rem; color: #64748b; margin: 5px 0;">
                <strong>NIS:</strong> {{ $absensi->nis }}
            </p>
        </div>

        {{-- Informasi Absensi --}}
        <div class="info-section">
            <div class="row">
                <div class="col-md-6">
                    <div style="margin-bottom: 15px;">
                        <small class="text-muted fw-bold d-block mb-2" style="text-transform: uppercase; letter-spacing: 0.5px;">📅 Tanggal</small>
                        <p class="fw-bold" style="font-size: 1.1rem; color: #1e293b;">
                            {{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d F Y (l)') }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="margin-bottom: 15px;">
                        <small class="text-muted fw-bold d-block mb-2" style="text-transform: uppercase; letter-spacing: 0.5px;">⏰ Jam Tercatat</small>
                        <p class="fw-bold" style="font-size: 1.1rem; color: #1e293b;">
                            {{ $absensi->qr_generated_at ? $absensi->qr_generated_at->format('H:i:s') : 'Otomatis' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Badge --}}
        <div style="margin: 20px 0; text-align: center;">
            <small class="text-muted fw-bold d-block mb-2" style="text-transform: uppercase; letter-spacing: 0.5px;">📊 Status Kehadiran</small>
            <span class="badge-status badge-{{ strtolower($absensi->status) }}">
                {{ strtoupper($absensi->status) }}
            </span>
        </div>

        {{-- QR Code Image --}}
        <div style="margin: 40px 0;">
            <small class="text-muted fw-bold d-block mb-3" style="text-transform: uppercase; letter-spacing: 0.5px;">🔲 QR Code</small>
            <img src="{{ $qrUrl }}" alt="QR Code" class="qr-image">
            <p style="font-size: 0.9rem; color: #64748b; margin-top: 15px;">
                <i class="fas fa-info-circle me-2"></i>
                QR Code ini berisi: NIS | Tanggal | Status
            </p>
        </div>

        {{-- Keterangan --}}
        @if($absensi->keterangan)
        <div class="info-section">
            <small class="text-muted fw-bold d-block mb-2" style="text-transform: uppercase; letter-spacing: 0.5px;">📝 Keterangan</small>
            <p class="mb-0" style="color: #1e293b;">{{ $absensi->keterangan }}</p>
        </div>
        @endif

        {{-- Action Buttons --}}
        <div class="action-buttons">
            <a href="{{ route('absensi.downloadQR', $absensi->id) }}" class="btn-action btn-download" onclick="return confirm('Download QR Code ini?')">
                <i class="fas fa-download me-2"></i>Download QR Code
            </a>
            <button class="btn-action btn-print" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Cetak
            </button>
            <a href="{{ route('absensi.index') }}" class="btn-action btn-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    {{-- Print Styles --}}
    <style media="print">
        @media print {
            body {
                background: white;
            }
            .qr-container, .action-buttons {
                display: none;
            }
            .qr-card {
                box-shadow: none;
                border: 1px solid #e5e7eb;
            }
        }
    </style>

    {{-- Auto-Refresh QR Code untuk menghindari cache browser --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qrImage = document.querySelector('.qr-image');
            
            if (qrImage) {
                // Refresh QR code setiap 5 detik dengan cache-busting
                setInterval(function() {
                    const baseUrl = qrImage.src.split('?')[0]; // Hapus parameter lama
                    qrImage.src = baseUrl + '?t=' + new Date().getTime();
                }, 5000);
            }
        });
    </script>

</div>
@endsection
