@extends('layouts.master')

@section('title', 'Ultimate Dashboard - SIM SEKOLAH')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid py-5 fade-in">
    
    {{-- 1. HEADER & DIGITAL CLOCK --}}
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="header-box shadow-lg d-flex align-items-center">
                <div class="me-4 d-none d-md-block">
                    <div class="bg-white bg-opacity-20 rounded-circle p-3 shadow-lg" style="width: 110px; height: 110px; backdrop-filter: blur(10px); border: 2px solid rgba(255,255,255,0.3);">
                        <img src="https://cdn-icons-png.flaticon.com/512/3429/3429433.png" class="img-fluid" alt="Admin" style="filter: brightness(0) invert(1);">
                    </div>
                </div>
                <div>
                    <h1 class="mb-2">Pusat Kendali {{ session('nama_kelas_aktif') ?? 'Sistem' }} 🚀</h1>
                    <p class="fs-5 opacity-85 mb-0">Selamat bekerja, <b>{{ Auth::guard('guru')->user()->nama_guru }}</b>. 
                        @if(session('nama_kelas_aktif'))
                            Anda sedang mengelola kelas <b>{{ session('nama_kelas_aktif') }}</b>.
                        @else
                            Silakan pilih kelas untuk memfilter data.
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card-pro h-100 shadow-lg" style="background: var(--dark-grad);">
                <div class="clock-box h-100 d-flex flex-column justify-content-center">
                    <h1 id="clock" class="fw-bold display-4 mb-0 text-white" style="letter-spacing: 2px;">00:00:00</h1>
                    <p id="date" class="text-uppercase small fw-bold opacity-50 mt-3 mb-0 text-white"></p>
                </div>
            </div>
        </div>
    </div>

    {{-- CEK APAKAH GURU SUDAH PILIH KELAS? --}}
    @if(session('id_kelas_aktif') || Auth::guard('guru')->user()->role == 'admin')

        {{-- 2. STATS COUNTER --}}
        <div class="row g-4 mb-5">
            @if(Auth::guard('guru')->user()->role == 'admin' && !session('id_kelas_aktif'))
                {{-- 👑 TAMPILAN KHUSUS ADMIN (4 KOTAK) --}}
                <div class="col-md-6 col-lg-3">
                    <div class="card-pro stat-card border-primary" style="border-bottom-color: #6366f1;">
                        <div class="icon text-primary"><i class="fas fa-user-graduate"></i></div>
                        <h6 class="text-muted fw-bold small mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Total Siswa</h6>
                        <h2 class="text-primary mb-1">{{ $jumlah_siswa }}</h2>
                        <small class="text-muted">Terdaftar Aktif</small>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card-pro stat-card border-success" style="border-bottom-color: #10b981;">
                        <div class="icon text-success"><i class="fas fa-chalkboard-teacher"></i></div>
                        <h6 class="text-muted fw-bold small mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Total Guru</h6>
                        <h2 class="text-success mb-1">{{ $jumlah_guru }}</h2>
                        <small class="text-muted">Pengajar Aktif</small>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card-pro stat-card border-warning" style="border-bottom-color: #f59e0b;">
                        <div class="icon text-warning"><i class="fas fa-school"></i></div>
                        <h6 class="text-muted fw-bold small mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Total Kelas</h6>
                        <h2 class="text-warning mb-1">{{ $jumlah_kelas }}</h2>
                        <small class="text-muted">Kelas Tersedia</small>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card-pro stat-card border-danger" style="border-bottom-color: #ef4444;">
                        <div class="icon text-danger"><i class="fas fa-tasks"></i></div>
                        <h6 class="text-muted fw-bold small mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Tugas Aktif</h6>
                        <h2 class="text-danger mb-1">{{ $jumlah_tugas }}</h2>
                        <small class="text-muted">Sedang Berlangsung</small>
                    </div>
                </div>
            @else
                {{-- 👨‍🏫 TAMPILAN GURU / KELAS AKTIF (2 KOTAK) --}}
                <div class="col-md-6">
                    <div class="card-pro stat-card border-primary" style="border-bottom-color: #6366f1;">
                        <div class="icon text-primary"><i class="fas fa-user-graduate"></i></div>
                        <h6 class="text-muted fw-bold small mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Siswa Kelas</h6>
                        <h2 class="text-primary mb-1">{{ $jumlah_siswa }}</h2>
                        <small class="text-muted">Terdaftar</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-pro stat-card border-danger" style="border-bottom-color: #ef4444;">
                        <div class="icon text-danger"><i class="fas fa-tasks"></i></div>
                        <h6 class="text-muted fw-bold small mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Tugas Kelas</h6>
                        <h2 class="text-danger mb-1">{{ $jumlah_tugas }}</h2>
                        <small class="text-muted">Sedang Berlangsung</small>
                    </div>
                </div>
            @endif
        </div>

        <div class="row g-4">
            {{-- 3. KIRI: GRAFIK & JADWAL --}}
            <div class="col-lg-8">
                <div class="card-pro p-4 shadow-sm mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-chart-pie me-2" style="color: #6366f1;"></i>Statistik Absensi {{ session('nama_kelas_aktif') ?? 'Siswa' }} Hari Ini</h5>
                            <small class="text-muted mt-1 d-block">Analisis kedisiplinan siswa</small>
                        </div>
                        <span class="badge bg-light text-dark rounded-pill px-3 py-2 border" style="border-color: #e0e7ff !important;">{{ date('d M Y') }}</span>
                    </div>
                    <canvas id="absensiChart" style="max-height: 300px;"></canvas>
                </div>

                <div class="card-pro shadow-sm" style="border-radius: 20px; overflow: hidden;">
                    <div class="p-4 d-flex justify-content-between align-items-center border-bottom" style="border-color: #f0f4ff; background: linear-gradient(135deg, #f0f9ff, #f5f3ff);">
                        <div>
                            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-calendar-check me-2" style="color: #10b981;"></i>Jadwal Mengajar Hari Ini</h5>
                            <small class="text-muted mt-1 d-block">{{ date('l, d F Y', strtotime('now')) }}</small>
                        </div>
                        <a href="{{ route('jadwal.index') }}" class="btn btn-sm btn-light rounded-pill px-3 border fw-bold">Lihat Semua</a>
                    </div>
                    <div style="max-height: 450px; overflow-y: auto;">
                        @forelse($jadwal_hari_ini ?? [] as $j)
                            @php
                                $isBreak = str_contains(strtolower($j->mata_pelajaran), 'istirahat') || 
                                           str_contains(strtolower($j->mata_pelajaran), 'sholat') || 
                                           str_contains(strtolower($j->mata_pelajaran), 'break');
                            @endphp
                            <div style="padding: 18px 20px; border-bottom: 1px solid #e5e7eb; background: {{ $isBreak ? '#fff5f5' : 'white' }}; transition: 0.3s;">
                                <div class="d-flex justify-content-between align-items-start gap-3" style="padding: 8px 0;">
                                    <div style="flex-grow: 1; min-width: 0;">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="fw-bold px-3 py-1 rounded-pill" style="background: {{ $isBreak ? '#fee2e2' : '#f0f4ff' }}; color: {{ $isBreak ? '#dc2626' : '#6366f1' }}; font-size: 0.85rem; font-weight: 700;">
                                                {{ substr($j->jam_mulai ?? $j->jam, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}
                                            </span>
                                        </div>
                                        <h6 class="fw-bold mb-1" style="font-size: 1rem; color: {{ $isBreak ? '#ef4444' : '#1e293b' }}; word-break: break-word;">
                                            {{ $j->mata_pelajaran ?? $j->mapel }}
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fas fa-door-open me-1"></i> 
                                            Kelas {{ $j->kelas }}
                                        </small>
                                    </div>
                                    <span class="status-badge badge rounded-pill py-2 px-3" style="background: linear-gradient(135deg, #10b981, #059669); color: white; font-weight: 600; font-size: 0.8rem; white-space: nowrap;">
                                        AKTIF
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8" style="padding: 50px 20px;">
                                <i class="fas fa-calendar-times fa-3x opacity-25 mb-3 d-block"></i>
                                <p class="text-muted fw-bold mb-0">Belum ada jadwal hari ini</p>
                                <small class="text-muted">Nikmati hari istirahat Anda atau lihat jadwal lengkap</small>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- 4. KANAN: AKSI CEPAT, KALENDER & DEADLINE --}}
            <div class="col-lg-4">
                
                {{-- Aksi Cepat --}}
                <div class="card-pro p-4 shadow-sm mb-4 border-top" style="border-top: 5px solid #f59e0b !important; animation-delay: 0.1s;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-bolt me-2" style="color: #f59e0b;"></i>Aksi Cepat</h5>
                    </div>
                    
                    <a href="{{ route('absensi.index') }}" class="btn-quick shadow-xs">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3 text-center" style="width: 40px;"><i class="fas fa-calendar-check text-primary"></i></div>
                        <div>
                            <div class="fw-600">Kelola Absensi</div>
                            <small class="text-muted">Catat kehadiran</small>
                        </div>
                    </a>
                    <a href="{{ route('tugas.create') }}" class="btn-quick shadow-xs">
                        <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3 text-center" style="width: 40px;"><i class="fas fa-upload text-success"></i></div>
                        <div>
                            <div class="fw-600">Input Tugas Baru</div>
                            <small class="text-muted">Buat tugas baru</small>
                        </div>
                    </a>
                    
                    @if(Auth::guard('guru')->user()->role == 'admin')
                    <a href="{{ route('siswa.create') }}" class="btn-quick shadow-xs">
                        <div class="bg-info bg-opacity-10 p-2 rounded-3 me-3 text-center" style="width: 40px;"><i class="fas fa-user-plus text-info"></i></div>
                        <div>
                            <div class="fw-600">Tambah Siswa</div>
                            <small class="text-muted">Daftar baru</small>
                        </div>
                    </a>
                    @endif

                    {{-- Tombol Keluar Kelas --}}
                    @if(session('id_kelas_aktif'))
                    <div class="mt-5">
                        <a href="{{ route('guru.keluar-kelas') }}" class="btn btn-danger w-100 rounded-pill py-3 fw-bold shadow-lg animate__animated animate__pulse animate__infinite" style="transition: 0.3s; font-size: 1rem; border: none; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                            <i class="fas fa-door-open me-2 fa-lg"></i> KELUAR / GANTI KELAS
                        </a>
                        <small class="text-muted d-block text-center mt-2" style="font-size: 0.75rem;">Klik untuk pindah ke ruangan kelas lain.</small>
                    </div>
                    @endif
                </div>

                {{-- 🚀 WIDGET KALENDER MINI --}}
                <div class="card-pro p-4 shadow-sm mb-4 border-top" style="border-top: 5px solid #06b6d4 !important; animation-delay: 0.2s;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-calendar-alt me-2" style="color: #06b6d4;"></i>Kalender</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-light border rounded-circle shadow-sm" id="prevMonth" style="transition: 0.2s;"><i class="fas fa-chevron-left"></i></button>
                            <button class="btn btn-sm btn-light border rounded-circle shadow-sm" id="nextMonth" style="transition: 0.2s;"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                    
                    <div class="text-center fw-bold" id="monthYear" style="color: #6366f1; font-size: 1.1rem; margin-bottom: 15px;"></div>
                    
                    {{-- Nama Hari --}}
                    <div class="calendar-grid">
                        <div class="calendar-day-header text-danger">Min</div>
                        <div class="calendar-day-header">Sen</div>
                        <div class="calendar-day-header">Sel</div>
                        <div class="calendar-day-header">Rab</div>
                        <div class="calendar-day-header">Kam</div>
                        <div class="calendar-day-header">Jum</div>
                        <div class="calendar-day-header text-primary">Sab</div>
                    </div>
                    {{-- Tanggal --}}
                    <div class="calendar-grid" id="calendarGrid"></div>
                </div>

                {{-- Deadline Tugas --}}
                <div class="card-pro p-4 shadow-sm border-top" style="border-top: 5px solid #ef4444 !important; animation-delay: 0.3s;">
                    <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-tasks me-2" style="color: #ef4444;"></i>Deadline Tugas {{ session('nama_kelas_aktif') }}</h5>
                    @forelse($tugas_terbaru ?? [] as $t)
                    <div class="d-flex align-items-center mb-3 p-3 rounded-3" style="background: linear-gradient(135deg, #fef2f2, #f9fafb); border: 1px solid #fee2e2;">
                        <div class="me-3 text-danger"><i class="fas fa-file-pdf fa-2x"></i></div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0 small text-uppercase" style="font-size: 0.8rem;">{{ $t->judul_tugas }}</h6>
                            <small class="text-muted">Sampai: <b class="text-danger">{{ $t->deadline }}</b></small>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-muted py-4 small">Belum ada tugas di kelas ini.</p>
                    @endforelse
                </div>

            </div>
        </div>

    @else
        {{-- 🛑 TAMPILAN JIKA BELUM PILIH KELAS --}}
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="warning-box shadow-lg fade-in">
                    <div class="mb-4 animate__animated animate__bounce">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" style="width: 150px;" alt="Pilih Kelas">
                    </div>
                    <h2 class="fw-bold text-dark mb-3">Akses Data Terkunci!</h2>
                    <p class="text-muted fs-5 mb-4">Maaf Gus, kamu belum memilih kelas yang ingin dikelola.<br>Silakan pilih kelas terlebih dahulu untuk melihat statistik, jadwal, dan tugas.</p>
                    <a href="{{ route('guru.pilih-kelas') }}" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg" style="background: var(--primary-grad); border: none;">
                        <i class="fas fa-chalkboard me-2"></i> Pilih Kelas Sekarang
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

@if(session('id_kelas_aktif') || Auth::guard('guru')->user()->role == 'admin')
<script>
    // 1. JAM DIGITAL
    function updateClock() {
        const now = new Date();
        const clockEl = document.getElementById('clock');
        const dateEl = document.getElementById('date');
        if (clockEl) {
            clockEl.innerText = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }
        if (dateEl) {
            dateEl.innerText = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        }
    }
    setInterval(updateClock, 1000); 
    updateClock();

    // 2. GRAFIK ABSENSI - Dengan Error Handling
    document.addEventListener('DOMContentLoaded', function() {
        const chartCanvas = document.getElementById('absensiChart');
        if (chartCanvas) {
            try {
                const ctx = chartCanvas.getContext('2d');
                if (ctx) {
                    const chartData = {
                        hadir: parseInt('{{ $hadir ?? 0 }}') || 0,
                        sakit: parseInt('{{ $sakit ?? 0 }}') || 0,
                        izin: parseInt('{{ $izin ?? 0 }}') || 0,
                        alpa: parseInt('{{ $alpa ?? 0 }}') || 0
                    };

                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Hadir', 'Sakit', 'Izin', 'Alpa'],
                            datasets: [{
                                label: 'Jumlah Siswa',
                                data: [chartData.hadir, chartData.sakit, chartData.izin, chartData.alpa],
                                backgroundColor: ['#6366f1', '#0ea5e9', '#f59e0b', '#ef4444'],
                                borderColor: 'white',
                                borderWidth: 4,
                                borderRadius: 10
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { 
                                legend: { 
                                    position: 'bottom',
                                    labels: {
                                        font: { size: 12, weight: 600 },
                                        padding: 20,
                                        usePointStyle: true
                                    }
                                }
                            }
                        }
                    });
                }
            } catch (error) {
                console.error('Error initializing chart:', error);
            }
        }
    });

    // 🚀 3. WIDGET KALENDER LOGIC
    const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    const grid = document.getElementById("calendarGrid");
    const monthYear = document.getElementById("monthYear");
    
    if (grid && monthYear) {
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        const realDate = new Date();

        function renderCalendar(month, year) {
            grid.innerHTML = "";
            monthYear.innerText = `${monthNames[month]} ${year}`;

            let firstDay = new Date(year, month, 1).getDay();
            let daysInMonth = new Date(year, month + 1, 0).getDate();
            let daysInPrevMonth = new Date(year, month, 0).getDate();

            for (let i = firstDay; i > 0; i--) {
                grid.innerHTML += `<div class="calendar-date muted">${daysInPrevMonth - i + 1}</div>`;
            }

            for (let i = 1; i <= daysInMonth; i++) {
                let isToday = (i === realDate.getDate() && month === realDate.getMonth() && year === realDate.getFullYear()) ? "active" : "";
                grid.innerHTML += `<div class="calendar-date ${isToday}">${i}</div>`;
            }
        }

        const prevBtn = document.getElementById("prevMonth");
        const nextBtn = document.getElementById("nextMonth");

        if (prevBtn && nextBtn) {
            prevBtn.addEventListener("click", () => {
                currentMonth--;
                if (currentMonth < 0) { currentMonth = 11; currentYear--; }
                renderCalendar(currentMonth, currentYear);
            });

            nextBtn.addEventListener("click", () => {
                currentMonth++;
                if (currentMonth > 11) { currentMonth = 0; currentYear++; }
                renderCalendar(currentMonth, currentYear);
            });

            renderCalendar(currentMonth, currentYear);
        }
    }
</script>
@endif
@endsection