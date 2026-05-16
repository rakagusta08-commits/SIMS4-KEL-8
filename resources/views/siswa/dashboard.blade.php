@extends('layouts.master')

@section('title', 'Student Space - SIM SEKOLAH')

@section('content')
{{-- FONT Bawaan --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

{{-- 🚀 TAMBAHAN FIX: LIBRARY ANIMASI BIAR HIDUP DAN GOYANG! --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    :root {
        --primary-grad: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --student-grad: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
        --dark-grad: linear-gradient(135deg, #232526 0%, #414345 100%);
        --success-grad: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --warning-grad: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    body { 
        font-family: 'Inter', sans-serif; 
        background-color: #f5f7fa;
        color: #333; 
        min-height: 100vh;
    }
    
    .fade-in { animation: fadeIn 0.8s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    
    @keyframes slideInUp { 
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    @keyframes popIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(13, 110, 253, 0.3); }
        50% { box-shadow: 0 0 40px rgba(13, 110, 253, 0.6); }
    }

    /* CARD STYLING SAMA DENGAN ADMIN */
    .card-pro { 
        border: none; 
        border-radius: 24px; 
        transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
        overflow: hidden;
        animation: slideInUp 0.6s ease-out forwards;
    }
    .card-pro:hover { 
        transform: translateY(-12px) scale(1.01); 
        box-shadow: 0 25px 50px rgba(13, 110, 253, 0.15); 
    }

    /* HEADER KHUSUS SISWA */
    .header-box {
        background: var(--student-grad);
        color: white;
        border-radius: 30px;
        padding: 40px;
        position: relative;
        box-shadow: 0 20px 50px rgba(13, 110, 253, 0.2);
        overflow: hidden;
    }
    .header-box::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    .header-box > * {
        position: relative;
        z-index: 1;
    }
    
    .clock-box {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 20px;
        padding: 20px;
        animation: pulse-glow 3s ease-in-out infinite;
    }

    /* QUICK MENU BUTTONS */
    .menu-cepat-btn {
        display: block;
        padding: 20px;
        border-radius: 20px;
        background: white;
        text-align: center;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid #eee;
        position: relative;
        overflow: hidden;
        animation: popIn 0.5s ease-out backwards;
    }
    .menu-cepat-btn:nth-child(1) { animation-delay: 0.1s; }
    .menu-cepat-btn:nth-child(2) { animation-delay: 0.2s; }
    .menu-cepat-btn:nth-child(3) { animation-delay: 0.3s; }
    .menu-cepat-btn:nth-child(4) { animation-delay: 0.4s; }
    
    .menu-cepat-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: var(--student-grad);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
        z-index: 0;
        opacity: 0.1;
    }
    .menu-cepat-btn:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .menu-cepat-btn:hover {
        transform: translateY(-8px) scale(1.05);
        box-shadow: 0 20px 40px rgba(13, 110, 253, 0.2);
        border-color: #0d6efd;
    }
    .menu-cepat-btn > * {
        position: relative;
        z-index: 1;
    }
    
    .icon-circle {
        width: 60px; height: 60px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 15px auto;
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }
    .menu-cepat-btn:hover .icon-circle {
        transform: scale(1.15) rotate(10deg);
    }
</style>

<div class="container-fluid py-4 fade-in">
    
    {{-- 1. HEADER & DIGITAL CLOCK (Serasi dengan Admin) --}}
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="header-box shadow-lg d-flex align-items-center animate__animated animate__fadeInDown">
                <div class="me-4 d-none d-md-block">
                    <div class="bg-white rounded-circle p-3 shadow-sm" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-graduate fa-3x text-primary animate__animated animate__pulse animate__infinite"></i>
                    </div>
                </div>
                <div>
                    <h1 class="fw-bold mb-2">Student Space 🎓</h1>
                    <p class="fs-5 opacity-75 mb-0">Selamat datang, <b>{{ Auth::guard('siswa')->user()->nama_siswa }}</b>. Siap belajar hari ini?</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 text-center animate__animated animate__fadeInDown animate__delay-1s">
            <div class="card-pro h-100 shadow-lg bg-dark text-white p-4" style="background: var(--dark-grad);">
                <div class="clock-box h-100 d-flex flex-column justify-content-center">
                    <h1 id="clock" class="fw-bold display-4 mb-0" style="letter-spacing: 2px;">00:00:00</h1>
                    <p id="date" class="text-uppercase small fw-bold opacity-50 mt-2 mb-0"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- 2. KARTU PROFIL PREMIUM --}}
        <div class="col-lg-4">
            <div class="card-pro shadow-sm text-center p-4 mb-4 bg-white border-top border-4 border-primary animate__animated animate__fadeInLeft">
                <div class="mb-3 position-relative d-inline-block">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('siswa')->user()->nama_siswa) }}&background=0D6EFD&color=fff&size=128&bold=true" 
                         class="rounded-circle shadow-md border border-4 border-white" width="120">
                    <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-light rounded-circle" title="Siswa Aktif">
                        <span class="visually-hidden">Siswa Aktif</span>
                    </span>
                </div>
                <h5 class="fw-bold mb-1 text-dark" style="font-size: 1.1rem;">{{ Auth::guard('siswa')->user()->nama_siswa }}</h5>
                <p class="text-primary fw-bold mb-3" style="font-size: 0.9rem;">{{ Auth::guard('siswa')->user()->nis }}</p>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 mb-3 rounded-pill border border-primary border-opacity-25" style="font-size: 0.8rem;">SMKN 4 BANDUNG</span>
                
                <div class="text-start bg-light p-3 rounded-3">
                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom" style="font-size: 0.9rem;">
                        <small class="text-muted fw-bold">Kelas</small>
                        <span class="fw-bold text-dark"><i class="fas fa-door-open me-1" style="font-size: 0.85rem;"></i>{{ Auth::guard('siswa')->user()->kelas }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom" style="font-size: 0.9rem;">
                        <small class="text-muted fw-bold">Gender</small>
                        <span class="fw-bold text-dark">
                            <i class="fas {{ Auth::guard('siswa')->user()->jenkel == 'L' ? 'fa-mars text-info' : 'fa-venus text-danger' }} me-1" style="font-size: 0.8rem;"></i>
                            {{ Auth::guard('siswa')->user()->jenkel == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between" style="font-size: 0.9rem;">
                        <small class="text-muted fw-bold">Alamat</small>
                        <span class="fw-bold text-dark text-end" style="max-width: 50%; font-size: 0.85rem;"><i class="fas fa-map-marker-alt me-1 text-warning" style="font-size: 0.8rem;"></i>{{ Str::limit(Auth::guard('siswa')->user()->alamat, 20) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. KONTEN UTAMA & MENU CEPAT --}}
        <div class="col-lg-8">
            <div class="row g-4 mb-4">
                {{-- Statistik Kehadiran --}}
                <div class="col-md-6">
                    <div class="card-pro bg-white p-4 shadow-sm h-100 border-start border-4 border-success animate__animated animate__fadeInUp">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-muted fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Kehadiran Bulan Ini</h6>
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <h1 class="fw-bold text-success mb-0 me-3" style="font-size: 2.5rem;">100%</h1>
                            <div class="progress w-100 rounded-pill" style="height: 10px; background-color: #e9ecef;">
                                <div class="progress-bar bg-success rounded-pill" role="progressbar" style="width: 100%"></div>
                            </div>
                        </div>
                        <small class="text-success fw-bold"><i class="fas fa-fire me-1"></i> Perfect Attendance!</small>
                    </div>
                </div>

                {{-- Notifikasi / Pengumuman --}}
                <div class="col-md-6">
                    <div class="card-pro bg-white p-4 shadow-sm h-100 border-start border-4 border-warning animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-muted fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Informasi Sekolah</h6>
                            <i class="fas fa-bell text-warning fa-lg animate__animated animate__swing animate__infinite animate__slower"></i>
                        </div>
                        <div class="alert bg-warning bg-opacity-10 border border-warning border-opacity-50 text-dark p-3 rounded-2 mb-0" style="font-size: 0.9rem;">
                            <b class="d-block mb-1"><i class="fas fa-bullhorn me-1"></i> Perhatian!</b>
                            <span style="font-size: 0.85rem;">Absensi jangan lupa ! Bahagia selalu</span>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Menu Cepat (Shortcut) --}}
            <div class="card-pro bg-white shadow-sm p-4 animate__animated animate__fadeInRight" style="background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 100%);">
                <h5 class="fw-bold mb-4 text-dark" style="font-size: 1.3rem;"><i class="fas fa-rocket me-2 text-primary"></i>Akses Cepat</h5>
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <a href="{{ route('siswa.absensi.index') }}" class="menu-cepat-btn">
                            <div class="icon-circle bg-primary bg-opacity-10 text-primary"><i class="fas fa-clipboard-check fa-lg"></i></div>
                            <span class="fw-bold text-dark d-block" style="font-size: 0.9rem;">Absen</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('siswa.tugas') }}" class="menu-cepat-btn">
                            <div class="icon-circle bg-danger bg-opacity-10 text-danger"><i class="fas fa-tasks fa-lg"></i></div>
                            <span class="fw-bold text-dark d-block" style="font-size: 0.9rem;">Tugas Kelas</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('siswa.jadwal') }}" class="menu-cepat-btn">
                            <div class="icon-circle bg-success bg-opacity-10 text-success"><i class="fas fa-calendar-alt fa-lg"></i></div>
                            <span class="fw-bold text-dark d-block" style="font-size: 0.9rem;">Jadwal</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('siswa.profil') }}" class="menu-cepat-btn">
                            <div class="icon-circle bg-info bg-opacity-10 text-info"><i class="fas fa-user-edit fa-lg"></i></div>
                            <span class="fw-bold text-dark d-block" style="font-size: 0.9rem;">Profil Saya</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // SCRIPT DIGITAL CLOCK DARI ADMIN
    function updateClock() {
        const now = new Date();
        document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById('date').innerText = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
    }
    setInterval(updateClock, 1000); updateClock();
</script>
@endsection