@extends('layouts.master')

@section('title', 'Generate QR Code Absensi | SIM SEKOLAH')

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

    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 12px 30px;
        border-radius: 15px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: 0.3s ease;
        font-size: 1rem;
        text-decoration: none;
        display: inline-block;
    }

    .btn-back {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
    }

    .btn-back:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        color: white;
    }

    .timer-badge {
        display: inline-block;
        background: #d1fae5;
        color: #065f46;
        padding: 10px 20px;
        border-radius: 20px;
        font-weight: 700;
        margin: 15px 0;
    }

    .status-badge {
        display: inline-block;
        background: #fef3c7;
        color: #92400e;
        padding: 10px 20px;
        border-radius: 20px;
        font-weight: 700;
    }
</style>

<div style="padding: 40px;">
    <div class="qr-container">
        <div>
            <h1 class="fw-bold mb-1">QR Code Absensi 📱</h1>
            <p class="opacity-75 fs-5 mb-0">Suruh siswa scan QR code ini dengan kamera HP mereka</p>
        </div>
    </div>

    <div class="qr-card">
        {{-- Informasi Kelas --}}
        <div style="margin-bottom: 30px;">
            <h5 class="fw-bold text-dark mb-3">
                <i class="fas fa-chalkboard me-2" style="color: #6366f1;"></i>
                Informasi Kelas
            </h5>
            <p style="font-size: 1.3rem; font-weight: 800; color: #1e293b; margin-bottom: 10px;">
                {{ $kelas->nama_kelas }}
            </p>
            <p style="font-size: 1rem; color: #64748b; margin: 5px 0;">
                <i class="fas fa-door-open me-2"></i>
                <strong>Ruangan:</strong> {{ $kelas->ruangan ?? '-' }}
            </p>
        </div>

        {{-- Status QR --}}
        <div class="info-section">
            <div class="row">
                <div class="col-md-6">
                    <small class="text-muted fw-bold d-block mb-2" style="text-transform: uppercase; letter-spacing: 0.5px;">📅 Tanggal</small>
                    <p class="fw-bold" style="font-size: 1.1rem; color: #1e293b;">
                        {{ now()->translatedFormat('d F Y (l)') }}
                    </p>
                </div>
                <div class="col-md-6">
                    <small class="text-muted fw-bold d-block mb-2" style="text-transform: uppercase; letter-spacing: 0.5px;">⏱️ Berlaku</small>
                    <p class="fw-bold" style="font-size: 1.1rem; color: #065f46;">
                        30 Menit
                    </p>
                </div>
            </div>
        </div>

        {{-- QR Code Image --}}
        <div style="margin: 40px 0;">
            <small class="text-muted fw-bold d-block mb-3" style="text-transform: uppercase; letter-spacing: 0.5px;">🔲 QR Code</small>
            <div class="qr-image">
                {!! $qr_image !!}
            </div>
            <div class="timer-badge">
                <i class="fas fa-hourglass-end me-2"></i>
                Aktif 30 Menit
            </div>
            <p style="font-size: 0.9rem; color: #64748b; margin-top: 15px;">
                <i class="fas fa-info-circle me-2"></i>
                Siswa bisa scan dengan kamera HP. Tidak perlu aplikasi tambahan.
            </p>
        </div>

        {{-- Instruksi untuk Siswa --}}
        <div class="info-section" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); border-left-color: #3b82f6;">
            <h6 class="fw-bold mb-3" style="color: #1e40af;">
                <i class="fas fa-lightbulb me-2"></i>Instruksi untuk Siswa:
            </h6>
            <ol style="text-align: left; color: #1e40af; margin-bottom: 0;">
                <li>Buka aplikasi <strong>Kamera</strong> di HP</li>
                <li>Arahkan ke QR code ini</li>
                <li>Tap notifikasi link yang muncul</li>
                <li>Otomatis tercatat HADIR di database ✅</li>
            </ol>
        </div>

        {{-- Action Buttons --}}
        <div class="action-buttons">
            <a href="{{ route('absensi.index') }}" class="btn-action btn-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Kelas
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
</div>
@endsection
