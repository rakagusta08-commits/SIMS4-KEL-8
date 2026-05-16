<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIM4') | Sistem Informasi Sekolah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --primary:       #6366f1;
            --primary-dark:  #4f46e5;
            --primary-light: #eef2ff;
            --sidebar-w:     270px; 
            --header-h:      75px;  
            
            /* 🚀 Warna Sidebar Super Premium */
            --sidebar-bg:    #0f172a; /* Deep Navy Space */
            --sidebar-text:  #94a3b8;
            --sidebar-hover: rgba(255,255,255,0.06);
            --sidebar-active-bg: linear-gradient(135deg, rgba(99,102,241,0.2) 0%, rgba(99,102,241,0.05) 100%);
            
            --bg:            #f8fafc;
            --card-bg:       #ffffff;
            --border:        #e2e8f0;
            --text:          #0f172a;
            --muted:         #64748b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        /* ══════════════════════════════
           🚀 SIDEBAR ENTERPRISE LEVEL
        ══════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 1000;
            transition: transform .3s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid rgba(255,255,255,0.05);
            box-shadow: 4px 0 24px rgba(0,0,0,0.1);
        }

        /* Brand Logo Area (Menempel di Atas) */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 0 24px;
            height: var(--header-h);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            text-decoration: none;
            flex-shrink: 0;
            background: rgba(0,0,0,0.1);
        }
        .brand-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--primary) 0%, #60a5fa 100%);
            border-radius: 10px;
            display: grid; place-items: center;
            font-size: 18px; color: #fff;
            box-shadow: 0 4px 15px rgba(37,99,235,0.3);
        }
        .brand-name { font-size: 20px; font-weight: 800; color: #fff; letter-spacing: -0.5px; }
        .brand-sub { font-size: 11px; color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; }

        /* Area Menu Scrollable (Di Tengah) */
        .sidebar-menu-area {
            flex: 1; /* Mengisi sisa ruang kosong di tengah */
            overflow-y: auto;
            scrollbar-width: none; /* Hide scrollbar Firefox */
            padding-bottom: 20px;
        }
        .sidebar-menu-area::-webkit-scrollbar { display: none; } /* Hide scrollbar Chrome */

        /* Navigation Sections */
        .nav-section { padding: 25px 15px 5px; }
        .nav-section-label {
            font-size: 11px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 0 15px;
            margin-bottom: 12px;
        }

        /* Menu Items */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 14.5px;
            font-weight: 600;
            color: var(--sidebar-text);
            transition: all 0.3s ease;
            margin-bottom: 4px;
        }
        
        .nav-item i { 
            width: 24px; 
            text-align: center; 
            font-size: 16px; 
            transition: all 0.3s ease;
        }
        
        /* Hover Effect */
        .nav-item:hover {
            background: var(--sidebar-hover);
            color: #f8fafc;
            transform: translateX(4px);
        }
        .nav-item:hover i { color: #f8fafc; transform: scale(1.1); }

        /* 🌟 Active State Effect */
        .nav-item.active {
            background: var(--sidebar-active-bg);
            color: #ffffff;
            box-shadow: inset 4px 0 0 var(--primary);
        }
        .nav-item.active i { color: var(--primary); }

        /* User Profile Footer (Menempel di Bawah) */
        .sidebar-footer {
            padding: 20px 16px;
            background: rgba(0,0,0,0.25);
            border-top: 1px solid rgba(255,255,255,0.05);
            flex-shrink: 0;
        }
        .user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 14px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.05);
            transition: 0.3s;
        }
        .user-card:hover { background: rgba(255,255,255,0.08); }
        .user-avatar img { width: 42px; height: 42px; border-radius: 12px; border: 2px solid var(--primary); }
        .user-name { font-size: 14px; font-weight: 800; color: #fff; line-height: 1.2; }
        .user-role { font-size: 11px; color: var(--primary); font-weight: 700; text-transform: uppercase; margin-top: 3px; }
        
        .btn-logout-side {
            margin-left: auto;
            background: transparent;
            border: none;
            color: #ef4444;
            font-size: 18px;
            cursor: pointer;
            padding: 8px;
            border-radius: 10px;
            transition: all .2s;
            background: rgba(239,68,68,0.1);
        }
        .btn-logout-side:hover { color: #fff; background: #ef4444; transform: scale(1.05); }

        /* ══════════════════════════════
           MAIN AREA
        ══════════════════════════════ */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top Header */
        .topbar {
            height: var(--header-h);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 35px;
            gap: 15px;
            position: sticky;
            top: 0;
            z-index: 500;
        }
        
        .sidebar-toggle {
            display: none; 
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 18px;
            color: var(--text);
            cursor: pointer;
            padding: 8px 12px;
            margin-right: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        
        .topbar-title { font-size: 19px; font-weight: 800; letter-spacing: -0.5px; }
        .topbar-breadcrumb { font-size: 13.5px; color: var(--primary); font-weight: 600; }
        .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 14px; }

        .notif-btn {
            width: 44px; height: 44px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            display: grid; place-items: center;
            font-size: 20px;
            color: var(--muted);
            text-decoration: none;
            position: relative;
            transition: all .3s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        }
        .notif-btn:hover { border-color: var(--primary); color: var(--primary); transform: translateY(-2px); }
        .notif-dot {
            position: absolute; top: -2px; right: -2px;
            width: 14px; height: 14px;
            background: #ef4444;
            border-radius: 50%;
            border: 3px solid #fff;
        }

        /* Page Content */
        .page-content { padding: 35px; flex: 1; }

        /* Card override */
        .card {
            border: none !important;
            border-radius: 20px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04) !important;
            transition: all 0.3s;
        }
        .card:hover { transform: translateY(-4px); box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important; }
        .card-header {
            background: #fff !important;
            border-bottom: 1px solid var(--border) !important;
            font-weight: 800;
            font-size: 16px;
            padding: 20px 24px !important;
            border-radius: 20px 20px 0 0 !important;
        }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); box-shadow: 10px 0 30px rgba(0,0,0,0.3); }
            .main-wrapper { margin-left: 0; }
            .sidebar-toggle { display: block; }
            .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.6); backdrop-filter: blur(4px); z-index: 999; }
            .sidebar-overlay.open { display: block; }
            .page-content { padding: 20px; }
            .topbar { padding: 0 20px; }
        }

        @media (max-width: 768px) {
            .page-content { padding: 15px; }
            .topbar { padding: 0 15px; height: 65px; }
            .topbar-title { font-size: 16px; }
            .topbar-breadcrumb { font-size: 12px; }
            .notif-btn { width: 38px; height: 38px; font-size: 18px; }
            .card-header { padding: 15px !important; font-size: 15px; }
            .modal-dialog { margin: 0.5rem; }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .page-content { animation: fadeUp .5s cubic-bezier(0.16, 1, 0.3, 1); }
    </style>

    @stack('styles')
</head>
<body>

{{-- Mobile overlay --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">

    <a href="#" class="sidebar-brand">
        <div class="brand-icon"><i class="fas fa-bolt"></i></div>
        <div>
            <div class="brand-name">SIM<span style="color:#60a5fa">4</span> PRO</div>
            <div class="brand-sub">Modern Academic</div>
        </div>
    </a>

    @php
        $isGuru  = Auth::guard('guru')->check();
        $isSiswa = Auth::guard('siswa')->check();
        
        $userActive = $isGuru ? Auth::guard('guru')->user() : ($isSiswa ? Auth::guard('siswa')->user() : null);
        $name    = $userActive ? ($isGuru ? 'Guru' : $userActive->nama_siswa) : 'Guest';
        $roleLabel = $isGuru ? ucfirst($userActive->role) : ($isSiswa ? 'Siswa' : '');

        $notifCount = 0;
        $notifs = [];
        if($isGuru) {
            if(class_exists('\App\Models\PengumpulanTugas')) {
                $notifs = \App\Models\PengumpulanTugas::whereNull('nilai')->orderBy('created_at', 'desc')->take(5)->get();
                $notifCount = \App\Models\PengumpulanTugas::whereNull('nilai')->count();
            }
        }
    @endphp

    <div class="sidebar-menu-area">
        {{-- MENU GURU --}}
        @if($isGuru)
            <div class="nav-section">
                <div class="nav-section-label">Menu Utama</div>
                <a href="{{ route('guru.dashboard') }}"
                class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i> Dashboard
                </a>

                @if($userActive->role == 'admin')
                    <a href="{{ route('siswa.index') }}"
                    class="nav-item {{ request()->routeIs('siswa.index') ? 'active' : '' }}">
                        <i class="fas fa-users-viewfinder"></i> Data Siswa
                    </a>
                    <a href="{{ route('guru.index') }}"
                    class="nav-item {{ request()->routeIs('guru.index') ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-user"></i> Data Guru
                    </a>
                    <a href="{{ route('kelas.index') }}"
                    class="nav-item {{ request()->routeIs('kelas.index') ? 'active' : '' }}">
                        <i class="fas fa-building-columns"></i> Data Kelas
                    </a>
                @endif
            </div>

            <div class="nav-section">
                <div class="nav-section-label">Akademik</div>
                @if(session('id_kelas_aktif') || $userActive->role == 'admin')
                    <a href="{{ route('absensi.index') }}" class="nav-item {{ request()->routeIs('absensi.*') ? 'active' : '' }}">
                        <i class="fas fa-fingerprint"></i> Absensi Digital
                    </a>
                    <a href="{{ route('jadwal.index') }}" class="nav-item {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-day"></i> Jadwal Cerdas
                    </a>
                    <a href="{{ route('tugas.index') }}" class="nav-item {{ request()->routeIs('tugas.*') ? 'active' : '' }}">
                        <i class="fas fa-file-signature"></i> Penugasan
                    </a>
                @else
                    <a href="#" class="nav-item text-muted" onclick="alert('Akses Terkunci! Silakan pilih kelas di Dashboard terlebih dahulu.'); return false;" style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-fingerprint"></i> Absensi <i class="fas fa-lock ms-auto" style="color: #ef4444; font-size: 14px;"></i>
                    </a>
                    <a href="#" class="nav-item text-muted" onclick="alert('Akses Terkunci! Silakan pilih kelas di Dashboard terlebih dahulu.'); return false;" style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-calendar-day"></i> Jadwal <i class="fas fa-lock ms-auto" style="color: #ef4444; font-size: 14px;"></i>
                    </a>
                    <a href="#" class="nav-item text-muted" onclick="alert('Akses Terkunci! Silakan pilih kelas di Dashboard terlebih dahulu.'); return false;" style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-file-signature"></i> Tugas <i class="fas fa-lock ms-auto" style="color: #ef4444; font-size: 14px;"></i>
                    </a>
                @endif
            </div>

        {{-- MENU SISWA --}}
        @elseif($isSiswa)
            <div class="nav-section">
                <div class="nav-section-label">Student Hub</div>
                <a href="{{ route('siswa.dashboard') }}"
                class="nav-item {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-rocket"></i> Beranda
                </a>
                <a href="{{ route('siswa.absensi.index') }}"
                class="nav-item {{ request()->routeIs('siswa.absensi.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i> Absen
                </a>
                <a href="javascript:void(0);" onclick="openQRScanner()"
                class="nav-item">
                    <i class="fas fa-camera"></i> Scan QR Absen
                </a>
                <a href="{{ route('siswa.tugas') }}"
                class="nav-item {{ request()->routeIs('siswa.tugas') ? 'active' : '' }}">
                    <i class="fas fa-book-open"></i> Tugas Kelas
                </a>
                <a href="{{ route('siswa.jadwal') }}"
                class="nav-item {{ request()->routeIs('siswa.jadwal') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> Jadwal Pelajaran
                </a>
                <a href="{{ route('siswa.todo.index') }}"
                class="nav-item {{ request()->routeIs('siswa.todo.*') ? 'active' : '' }}">
                    <i class="fas fa-list-check"></i> To-Do List
                </a>
                <a href="{{ route('siswa.profil') }}"
                class="nav-item {{ request()->routeIs('siswa.profil') ? 'active' : '' }}">
                    <i class="fas fa-id-badge"></i> Profil Saya
                </a>
            </div>
        @endif
    </div>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}&background=2563eb&color=fff&bold=true" alt="{{ $name }}">
            </div>
            <div>
                <div class="user-name">{{ $name }}</div>
                <div class="user-role">{{ $roleLabel }}</div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="ms-auto">
                @csrf
                <button type="submit" class="btn-logout-side" title="Logout">
                    <i class="fas fa-power-off"></i>
                </button>
            </form>
        </div>
    </div>

</aside>

<div class="main-wrapper">

    <header class="topbar">
        <button class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars-staggered"></i>
        </button>
        <div>
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            <div class="topbar-breadcrumb">@yield('page-subtitle', 'Sistem Manajemen Modern')</div>
        </div>
        <div class="topbar-right">
            
            <div class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 border border-primary border-opacity-25 d-none d-md-block fw-bold" style="border-radius: 12px;">
                <i class="fas fa-shield-halved me-1"></i> {{ $roleLabel }}
            </div>

            @if(session('nama_kelas_aktif'))
                <div class="badge bg-info bg-opacity-10 text-info px-3 py-2 border border-info border-opacity-25 ms-2 d-none d-md-block fw-bold" style="border-radius: 12px;">
                    <i class="fas fa-door-open me-1"></i> Kelas {{ session('nama_kelas_aktif') }}
                </div>
            @endif

            <div class="dropdown ms-2">
                <a href="#" class="notif-btn" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    @if($notifCount > 0)
                        <div class="notif-dot animate__animated animate__pulse animate__infinite"></div>
                    @endif
                </a>
                
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-0" style="width: 360px; border-radius: 20px; z-index: 1050; overflow: hidden;">
                    <li class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white">
                        <span class="fw-bold text-dark fs-6"><i class="fas fa-inbox me-2 text-primary"></i>Pemberitahuan</span>
                        @if($notifCount > 0)
                            <span class="badge bg-danger rounded-pill px-2 py-1 shadow-sm">{{ $notifCount }} Baru</span>
                        @endif
                    </li>
                    <li>
                        <div style="max-height: 350px; overflow-y: auto;">
                            @if($isGuru && $notifCount > 0)
                                @foreach($notifs as $n)
                                    <a class="dropdown-item py-3 border-bottom text-wrap" href="{{ route('tugas.index') }}" style="transition: background 0.3s;">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; flex-shrink: 0; font-size: 18px;">
                                                <i class="fas fa-paper-plane"></i>
                                            </div>
                                            <div style="line-height: 1.4;">
                                                <span class="d-block text-dark fw-bold mb-1" style="font-size: 14.5px;">Tugas Belum Dinilai</span>
                                                <span class="d-block text-muted" style="font-size: 13px;">Siswa NIS <b class="text-dark">{{ $n->nis }}</b> mengirimkan jawaban baru.</span>
                                                <small class="text-primary mt-2 d-block fw-bold" style="font-size: 11px;"><i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($n->created_at)->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @elseif($isGuru && $notifCount == 0)
                                <div class="p-5 text-center text-muted">
                                    <i class="fas fa-mug-hot text-primary fa-3x mb-3 opacity-50"></i>
                                    <span class="d-block fw-bold text-dark fs-6">Semua Clear!</span>
                                    <span class="d-block mt-1" style="font-size: 13px;">Belum ada tugas baru yang menumpuk.</span>
                                </div>
                            @else
                                <div class="p-5 text-center text-muted">
                                    <i class="fas fa-bell-slash fa-2x mb-2 opacity-25"></i>
                                    <div style="font-size: 13px;">Belum ada notifikasi baru.</div>
                                </div>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>

            <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}&background=0f172a&color=fff&bold=true"
                 width="46" height="46" class="rounded-circle ms-3 shadow-sm border border-2 border-white" style="cursor:pointer; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
        </div>
    </header>

    <main class="page-content">
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center gap-3 mb-4 shadow-sm animate__animated animate__fadeInDown" style="border-radius: 16px;" role="alert">
                <i class="fas fa-check-circle fa-lg"></i> 
                <div>{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center gap-3 mb-4 shadow-sm animate__animated animate__shakeX" style="border-radius: 16px;" role="alert">
                <i class="fas fa-exclamation-triangle fa-lg"></i> 
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="text-center py-4 mt-auto" style="font-size:13px; font-weight: 600; color: #94a3b8; border-top: 1px solid var(--border); background: var(--card-bg);">
        &copy; {{ date('Y') }} <span style="color: var(--primary)">SIM4 PRO</span>. Innovated for SMKN 4 Bandung.
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('open');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('open');
    }
    
    // 🎯 BUKA QR SCANNER UNTUK SISWA
    function openQRScanner() {
        // Buka halaman scanner QR dengan modal atau redirect
        // Jika ada parameter token, gunakan itu; jika tidak, buka modal untuk input
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.id = 'qrScannerModal';
        modal.innerHTML = `
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-camera me-2"></i> Scan QR Code Absensi
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div id="qr-scanner" style="width: 100%; height: 400px; border-radius: 12px; overflow: hidden; background: #000;"></div>
                        <p class="text-muted text-center mt-3 mb-0">
                            <i class="fas fa-info-circle me-1"></i> Arahkan kamera ke QR Code dari guru Anda
                        </p>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
        
        // Load QR scanner library jika belum ada
        if (!window.QRScanner) {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/qr-scanner@1.4.2/qr-scanner.umd.min.js';
            script.onload = function() {
                initQRScanner();
            };
            document.head.appendChild(script);
        } else {
            initQRScanner();
        }
        
        function initQRScanner() {
            const video = document.createElement('video');
            video.style.width = '100%';
            video.style.height = '100%';
            document.getElementById('qr-scanner').innerHTML = '';
            document.getElementById('qr-scanner').appendChild(video);
            
            window.QRScanner.hasCamera().then(function(hasCamera) {
                if (hasCamera) {
                    window.QRScanner.setCamera(QRScanner.CAMERA_SETTINGS_IPHONE_11);
                    window.QRScanner.scan(function(data) {
                        if (data) {
                            bsModal.hide();
                            // Redirect ke halaman absensi dengan QR token
                            window.location.href = data; 
                        }
                    });
                    QRScanner.show();
                } else {
                    alert('Kamera tidak tersedia di perangkat ini');
                }
            });
            
            // Stop scanner saat modal ditutup
            modal.addEventListener('hidden.bs.modal', function() {
                if (window.QRScanner) {
                    window.QRScanner.hide();
                    window.QRScanner.destroy();
                }
                modal.remove();
            });
        }
    }
</script>
</body>
</html>