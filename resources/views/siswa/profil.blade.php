@extends('layouts.master')

@section('title', 'Profil Saya - SIM SEKOLAH')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --student-grad: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
        --glass-bg: rgba(255, 255, 255, 0.95);
    }
    body { font-family: 'Inter', sans-serif; background-color: #f0f2f5; }
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .card-pro { 
        border: none; 
        border-radius: 20px; 
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .card-pro:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
    
    .profile-banner {
        height: 140px;
        background: var(--student-grad);
        border-radius: 20px 20px 0 0;
        position: relative;
    }
    
    .avatar-wrapper {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: #fff;
        padding: 5px;
        position: absolute;
        bottom: -60px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    
    .avatar-circle {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: var(--student-grad);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        font-weight: 700;
        border: 2px solid #e9ecef;
    }

    .nav-pills .nav-link {
        border-radius: 50rem;
        padding: 10px 25px;
        font-weight: 600;
        color: #6c757d;
        transition: all 0.3s ease;
    }
    .nav-pills .nav-link.active {
        background: var(--student-grad);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }
    
    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #adb5bd;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .info-value {
        font-size: 1.05rem;
        font-weight: 600;
        color: #2b3445;
    }
</style>

<div class="container-fluid py-4 fade-in">
    
    <div class="row mb-4 align-items-center">
        <div class="col-12">
            <h3 class="fw-bold text-dark mb-0"><i class="fas fa-user-circle text-primary me-2"></i>Profil Saya</h3>
            <p class="text-muted">Kelola informasi data diri dan akun SIM Sekolah kamu di sini.</p>
        </div>
    </div>

    <div class="row g-4">
        {{-- KOLOM KIRI: KARTU PROFIL & STATUS --}}
        <div class="col-lg-4">
            {{-- Kartu Profil Utama --}}
            <div class="card card-pro bg-white mb-4 position-relative mt-2">
                <div class="profile-banner">
                    <div class="avatar-wrapper">
                        @if($siswa->foto_profil)
                            <img src="{{ asset('storage/uploads/profil/'.$siswa->foto_profil) }}" 
                                class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            @php
                                $inisial = strtoupper(substr($siswa->nama_siswa ?? $siswa->nama ?? 'S', 0, 2));
                            @endphp
                            <div class="avatar-circle">
                                {{ $inisial }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body text-center pt-5 mt-4 pb-4">
                    <h4 class="fw-bold text-dark mb-1">{{ $siswa->nama_siswa ?? $siswa->nama ?? 'Nama Siswa' }}</h4>
                    <p class="text-muted small mb-3"><i class="fas fa-graduation-cap me-1"></i>Siswa SMKN 4 Bandung</p>
                    <div class="d-inline-block bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-pill px-4 py-2 text-primary fw-bold">
                        <i class="fas fa-id-card me-2"></i>NIS: {{ $siswa->nis ?? 'Belum ada NIS' }}
                    </div>
                </div>
            </div>

            {{-- Kartu Status Akun --}}
            <div class="card card-pro bg-white">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-4"><i class="fas fa-shield-alt text-success me-2"></i>Informasi Akun</h6>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted"><i class="fas fa-toggle-on me-2"></i>Status Akun</span>
                        <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm"><i class="fas fa-check me-1"></i>Aktif</span>
                    </div>
                    <hr class="opacity-10">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted"><i class="fas fa-calendar-alt me-2"></i>Tahun Masuk</span>
                        <span class="fw-bold text-dark">2024/2027</span>
                    </div>
                    <hr class="opacity-10">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted"><i class="fas fa-user-tag me-2"></i>Role</span>
                        <span class="fw-bold text-primary">Siswa</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: DETAIL DATA --}}
        <div class="col-lg-8">
            <div class="card card-pro bg-white h-100">
                <div class="card-header bg-white p-4 border-0">
                    {{-- Navigasi Tabs --}}
                    <ul class="nav nav-pills" id="profilTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="data-diri-tab" data-bs-toggle="tab" data-bs-target="#data-diri" type="button" role="tab" aria-controls="data-diri" aria-selected="true">
                                <i class="fas fa-info-circle me-1"></i> Data Diri
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="biografi-tab" data-bs-toggle="tab" data-bs-target="#biografi" type="button" role="tab" aria-controls="biografi" aria-selected="false">
                                <i class="fas fa-pen-fancy me-1"></i> Biografi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="data-pribadi-tab" data-bs-toggle="tab" data-bs-target="#data-pribadi" type="button" role="tab" aria-controls="data-pribadi" aria-selected="false">
                                <i class="fas fa-user me-1"></i> Data Pribadi
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body p-4 pt-0">
                    <div class="tab-content" id="profilTabContent">
                        
                        {{-- TAB: DATA DIRI --}}
                        <div class="tab-pane fade show active" id="data-diri" role="tabpanel" aria-labelledby="data-diri-tab">
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-4 border-start border-4 border-primary h-100">
                                        <div class="info-label">Nama Lengkap</div>
                                        <div class="info-value">{{ $siswa->nama_siswa ?? $siswa->nama ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-4 border-start border-4 border-info h-100">
                                        <div class="info-label">Nomor Induk Siswa (NIS)</div>
                                        <div class="info-value">{{ $siswa->nis ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-4 border-start border-4 border-success h-100">
                                        <div class="info-label">Kelas Saat Ini</div>
                                        <div class="info-value"><i class="fas fa-door-open text-success me-2"></i>{{ $siswa->kelas ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-4 border-start border-4 border-warning h-100">
                                        <div class="info-label">Email</div>
                                        <div class="info-value"><i class="fas fa-envelope text-warning me-2"></i>{{ $siswa->email ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 bg-light rounded-4 border-start border-4 border-secondary">
                                        <div class="info-label">Alamat Lengkap</div>
                                        <div class="info-value"><i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $siswa->alamat ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Peringatan Data --}}
                            <div class="alert alert-warning border-0 bg-warning bg-opacity-10 d-flex align-items-center p-4 rounded-4 shadow-sm" role="alert">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning me-3"></i>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Perhatian!</h6>
                                    <p class="mb-0 small text-muted">Jika terdapat ketidaksesuaian data pada profil Anda, harap segera melapor ke bagian Tata Usaha atau hubungi Admin melalui email: <strong>smkn4bdg.sch.id</strong></p>
                                </div>
                            </div>
                        </div>

                        {{-- TAB: BIOGRAFI --}}
                        <div class="tab-pane fade" id="biografi" role="tabpanel" aria-labelledby="biografi-tab">
                            @if($siswa->biografi)
                                <div class="p-4 bg-light rounded-4 border-start border-4 border-info">
                                    <h6 class="fw-bold text-dark mb-3"><i class="fas fa-quote-left text-info me-2"></i>Biografi Saya</h6>
                                    <p class="text-dark mb-0" style="line-height: 1.8; font-size: 1.05rem;">
                                        {{ $siswa->biografi }}
                                    </p>
                                </div>
                                <div class="alert alert-info border-0 bg-info bg-opacity-10 mt-4 d-flex align-items-center p-4 rounded-4 shadow-sm" role="alert">
                                    <i class="fas fa-lightbulb fa-2x text-info me-3"></i>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">Tips</h6>
                                        <p class="mb-0 small text-muted">Ingin mengubah biografi? Klik tombol Edit Profil di bawah.</p>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-pen-fancy fa-5x text-muted opacity-25 mb-3"></i>
                                    <h5 class="fw-bold text-dark">Biografi Belum Diisi</h5>
                                    <p class="text-muted mb-4">Tuliskan biografi Anda untuk membuat profil lebih lengkap dan menarik.</p>
                                    <a href="{{ route('siswa.profil.edit') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                        <i class="fas fa-edit me-2"></i>Isi Biografi Sekarang
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- TAB: DATA PRIBADI --}}
                        <div class="tab-pane fade" id="data-pribadi" role="tabpanel" aria-labelledby="data-pribadi-tab">
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-4 border-start border-4 border-warning h-100">
                                        <div class="info-label">Tanggal Lahir</div>
                                        <div class="info-value">
                                            @if($siswa->tanggal_lahir)
                                                <i class="fas fa-birthday-cake text-warning me-2"></i>{{ $siswa->tanggal_lahir->format('d M Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-4 border-start border-4 border-info h-100">
                                        <div class="info-label">No. Telepon</div>
                                        <div class="info-value">
                                            @if($siswa->no_telepon)
                                                <i class="fas fa-phone text-info me-2"></i>{{ $siswa->no_telepon }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 bg-light rounded-4 border-start border-4 border-secondary">
                                        <div class="info-label">Alamat Lengkap</div>
                                        <div class="info-value">
                                            @if($siswa->alamat)
                                                <i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $siswa->alamat }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info border-0 bg-info bg-opacity-10 d-flex align-items-center p-4 rounded-4 shadow-sm" role="alert">
                                <i class="fas fa-info-circle fa-2x text-info me-3"></i>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Informasi Data Pribadi</h6>
                                    <p class="mb-0 small text-muted">Data pribadi Anda dijaga kerahasiaannya dan hanya digunakan untuk keperluan akademik.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Edit Profil --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('siswa.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                </a>
                <a href="{{ route('siswa.profil.edit') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                    <i class="fas fa-edit me-2"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection