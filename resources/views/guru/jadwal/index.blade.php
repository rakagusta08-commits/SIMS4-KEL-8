@extends('layouts.master')
@section('title', 'Jadwal Pelajaran | SIM SEKOLAH')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    :root {
        --primary-blue: #2563eb;
        --navy-dark: #0f172a;
        --soft-bg: #f8fafc;
        --accent: #6c5ce7;
    }
    .schedule-container { padding: 30px; background: var(--soft-bg); min-height: 100vh; }
    
    /* HEADER BANNER */
    .header-banner { 
        background: linear-gradient(135deg, var(--navy-dark) 0%, var(--primary-blue) 100%); 
        border-radius: 30px; 
        padding: 40px; 
        color: white; 
        margin-bottom: 40px; 
        box-shadow: 0 15px 30px rgba(37, 99, 235, 0.2); 
    }
    
    /* NAV TABS HARI */
    .nav-schedule { 
        display: flex; gap: 20px; margin-bottom: 45px; overflow-x: auto; padding: 10px 5px 25px 5px; scrollbar-width: none; 
    }
    .nav-schedule::-webkit-scrollbar { display: none; }
    .day-btn { 
        background: white; border-radius: 25px; color: var(--navy-dark); font-weight: 600; font-size: 1.25rem; 
        cursor: pointer; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); min-width: 170px; height: 85px; 
        border: 3px solid #e2e8f0; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 15px rgba(0,0,0,0.05); position: relative; 
    }
    .day-btn.active { 
        background: linear-gradient(135deg, #2563eb 0%, #704ba2 100%); color: white !important; border-color: transparent; 
        transform: translateY(-10px) scale(1.05); box-shadow: 0 15px 25px rgba(37, 99, 235, 0.4); 
    }
    .day-btn.active::after { 
        content: ''; position: absolute; bottom: -12px; left: 50%; transform: translateX(-50%); width: 30px; height: 6px; background: var(--primary-blue); border-radius: 10px; 
    }
    
    /* TIMELINE CARD */
    .timeline-card { 
        background: white; border: none; border-radius: 25px; border-left: 8px solid var(--accent); 
        transition: all 0.3s ease; box-shadow: 0 5px 20px rgba(0,0,0,0.05); 
    }
    .timeline-card:hover { transform: translateY(-8px); box-shadow: 0 12px 30px rgba(108, 92, 231, 0.2); }
    .time-badge { 
        background: #f1f5f9; color: var(--accent); padding: 8px 18px; border-radius: 12px; font-weight: 800; font-size: 0.9rem; border: 1px solid #e2e8f0; 
    }
    .subject-name { font-size: 1.35rem; font-weight: 800; color: var(--navy-dark); letter-spacing: -0.5px; }
    
    /* GAYA KHUSUS ISTIRAHAT */
    .break-card { border-left-color: #ff7675; background: #fff5f5; }
    .break-card .time-badge { background: #fee2e2; color: #ff7675; border-color: #ffc9c9; }
    
    /* TOMBOL AKSI */
    .action-btns { opacity: 0; transition: 0.3s; }
    .timeline-card:hover .action-btns { opacity: 1; }

    /* CSS BARU UNTUK BLOK JURUSAN */
    .jurusan-badge {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        color: white;
        padding: 12px 30px;
        border-radius: 50px;
        font-size: 1.4rem;
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.15);
        border: 2px solid #fff;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    .kelas-divider-line {
        height: 3px; 
        background: linear-gradient(90deg, #94a3b8, transparent); 
        border-radius: 3px;
        opacity: 0.5;
    }
    .kelas-wrapper {
        border-left: 3px dashed #cbd5e1;
        padding-left: 25px;
        margin-left: 25px;
        margin-bottom: 30px;
    }
</style>

<div class="schedule-container animate__animated animate__fadeIn">
    <div class="header-banner d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-1">Class Schedule <span class="fs-4">📅</span></h1>
            <p class="mb-0 opacity-75 fs-5">Sistem Informasi Manajemen Jadwal Cerdas</p>
        </div>
        @if(Auth::guard('guru')->user()->role == 'admin')
        <a href="{{ route('jadwal.create') }}" class="btn btn-light rounded-pill px-4 py-2 fw-bold shadow">
            <i class="fas fa-plus me-2 text-primary"></i>New Entry
        </a>
        @endif
    </div>

    <div class="nav-schedule nav nav-pills" id="pills-tab" role="tablist">
        @php $hariArray = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']; @endphp
        @foreach($hariArray as $idx => $h)
        <button class="day-btn {{ $idx == 0 ? 'active' : '' }}"
                id="pills-{{ $h }}-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-{{ $h }}"
                type="button">
            {{ $h }}
        </button>
        @endforeach
    </div>

    <div class="tab-content" id="pills-tabContent">
        @foreach($hariArray as $idx => $h)
        <div class="tab-pane fade {{ $idx == 0 ? 'show active' : '' }}" id="pills-{{ $h }}" role="tabpanel">
            
            @php
                // LOGIKA CERDAS: Mengelompokkan berdasarkan Jurusan Terlebih Dahulu
                $jadwalPerJurusan = $jadwals->where('hari', $h)->groupBy(function($j) {
                    // 1. Buang angka dan huruf romawi (seperti 10, 11, 12, X, XI, XII)
                    $kelasBersih = preg_replace('/\b(X|XI|XII|[0-9]+)\b/', '', strtoupper($j->kelas));
                    // 2. Cari singkatan jurusan yang tersisa (misal: RPL, TKJ, DKV)
                    preg_match('/[A-Z]{2,}/', $kelasBersih, $matches);
                    return $matches[0] ?? 'UMUM';
                });
            @endphp

            @forelse($jadwalPerJurusan as $namaJurusan => $jadwalJurusan)
                
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="jurusan-badge fw-bold">
                            <i class="fas fa-laptop-code text-info"></i> JURUSAN {{ $namaJurusan }}
                        </div>
                        <div class="flex-grow-1 ms-3 kelas-divider-line"></div>
                    </div>

                    @php
                        // Memecah lagi jadwal di dalam jurusan tersebut menjadi per Kelas
                        $jadwalPerKelas = $jadwalJurusan->groupBy('kelas');
                    @endphp

                    @foreach($jadwalPerKelas as $namaKelas => $jadwalsKelas)
                        <div class="kelas-wrapper">
                            <h4 class="fw-bold mb-3" style="color: var(--primary-blue);">
                                <i class="fas fa-users me-2 opacity-50"></i>{{ $namaKelas }}
                            </h4>

                            <div class="row g-4 mb-4">
                                @foreach($jadwalsKelas as $j)
                                    @php
                                        $isBreak = str_contains(strtolower($j->mata_pelajaran), 'istirahat') || 
                                                   str_contains(strtolower($j->mata_pelajaran), 'sholat');
                                    @endphp

                                    <div class="col-md-6 col-lg-4">
                                        <div class="card timeline-card {{ $isBreak ? 'break-card' : '' }} h-100">
                                            <div class="card-body p-4">
                                                <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <div class="time-badge">
                                                        <i class="far fa-clock me-1"></i> {{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}
                                                    </div>

                                                    @if(Auth::guard('guru')->user()->role == 'admin')
                                                    <div class="action-btns">
                                                        <a href="{{ route('jadwal.edit', $j->id) }}" class="btn btn-sm btn-light text-warning rounded-circle shadow-sm me-1"><i class="fas fa-edit"></i></a>
                                                        <form action="{{ route('jadwal.destroy', $j->id) }}" method="POST" class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" onclick="return confirm('Hapus jadwal {{ $j->mata_pelajaran }}?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    @endif
                                                </div>

                                                <div class="subject-name mb-2">
                                                    {{ $j->mata_pelajaran }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

            @empty
                <div class="col-12 text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-calendar-times fa-4x opacity-10"></i>
                    </div>
                    <h5 class="text-muted fw-bold">Belum ada jadwal untuk hari {{ $h }}.</h5>
                </div>
            @endforelse

        </div>
        @endforeach
    </div>
</div>

<script>
    // Memastikan tombol hari berubah warna saat diklik
    document.querySelectorAll('.day-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.day-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
@endsection