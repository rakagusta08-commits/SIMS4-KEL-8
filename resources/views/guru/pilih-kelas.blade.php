@extends('layouts.master')

@section('title', 'Pilih Kelas Mengajar')

@section('content')
<div class="container py-5">
    {{-- Header dengan Animasi Fade Down --}}
    <div class="text-center mb-5 animate-fade-down">
        <h2 class="fw-extrabold text-dark mb-2" style="letter-spacing: -1px;">
            Selamat Datang, <span class="text-primary">Guru</span>! 
        </h2>
        <p class="text-muted mx-auto" style="max-width: 500px;">
            Sistem telah mendeteksi jadwal Anda. Silakan pilih kelas di bawah ini untuk memulai sesi belajar mengajar.
        </p>
    </div>

    <div class="row g-4 justify-content-center">
        @forelse($kelas as $index => $item)
        {{-- Card dengan Animasi Stagger (Muncul bergantian) --}}
        <div class="col-md-4 col-lg-3 animate-card" style="animation-delay: {{ $index * 0.1 }}s">
            <div class="card h-100 border-0 shadow-sm text-center p-4 glass-card overflow-hidden position-relative">
                
                {{-- Dekorasi Latar Belakang --}}
                <div class="card-circle-bg"></div>

                <div class="position-relative z-index-2">
                    <div class="mb-4 mt-2">
                        <div class="icon-box mx-auto shadow-sm">
                            <i class="fas fa-chalkboard-teacher text-white"></i>
                        </div>
                    </div>
                    
                    <h4 class="fw-bold text-dark mb-1">{{ $item->nama_kelas }}</h4>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 mb-4 border border-primary border-opacity-10">
                        {{ $item->jurusan ?? 'Umum' }}
                    </span>

                    <div class="pt-2 border-top border-light mt-2">
                        <a href="{{ route('guru.set-kelas', $item->id) }}" class="btn btn-primary rounded-pill w-100 fw-bold py-2 shadow-sm btn-entrance">
                            Masuk Kelas <i class="fas fa-arrow-right ms-2 small"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center animate-fade-up">
            <img src="https://illustrations.popsy.co/amber/no-data.svg" width="200" class="mb-3">
            <h5 class="text-muted">Data kelas belum tersedia di sistem.</h5>
        </div>
        @endforelse
    </div>
</div>

<style>
    /* ══════════════════════════════
       ANIMATIONS & STYLES
    ══════════════════════════════ */
    .fw-extrabold { font-weight: 800; }

    /* Card Glassmorphism Effect */
    .glass-card {
        background: #ffffff;
        border-radius: 24px !important;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        cursor: default;
    }

    .glass-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.12) !important;
    }

    /* Icon Box */
    .icon-box {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border-radius: 20px;
        display: grid;
        place-items: center;
        font-size: 28px;
        transition: transform 0.3s ease;
    }
    
    .glass-card:hover .icon-box {
        transform: rotate(10deg) scale(1.1);
    }

    /* Decorative background circle */
    .card-circle-bg {
        position: absolute;
        top: -20px;
        right: -20px;
        width: 100px;
        height: 100px;
        background: rgba(37, 99, 235, 0.03);
        border-radius: 50%;
        z-index: 1;
    }

    /* Custom Button Animation */
    .btn-entrance {
        transition: all 0.3s;
    }
    .btn-entrance:hover {
        background: #1d4ed8 !important;
        box-shadow: 0 8px 15px rgba(37, 99, 235, 0.3) !important;
    }

    /* Keyframes */
    @keyframes fadeDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes cardIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    .animate-fade-down { animation: fadeDown 0.8s ease-out forwards; }
    .animate-card { 
        opacity: 0;
        animation: cardIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; 
    }

    .z-index-2 { position: relative; z-index: 2; }
</style>
@endsection