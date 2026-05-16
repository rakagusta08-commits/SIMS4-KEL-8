@extends('layouts.master')

@section('title', 'Tugas Kelas - SIM SEKOLAH')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --student-grad: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
        --soft-bg: #f8fafc;
    }
    body { font-family: 'Inter', sans-serif; background-color: var(--soft-bg); }
    
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    /* KARTU TUGAS */
    .card-pro { 
        border: none; 
        border-radius: 20px; 
        background: white;
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    .card-pro:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 15px 30px rgba(13, 110, 253, 0.1); 
    }
    
    .task-icon {
        width: 50px; height: 50px;
        border-radius: 15px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }

    /* HEADER BANNER */
    .header-banner {
        background: var(--student-grad);
        border-radius: 25px;
        padding: 35px;
        color: white;
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.2);
    }

    .btn-link-ref {
        background: rgba(13, 110, 253, 0.05);
        color: #0d6efd;
        border: 1px dashed #0d6efd;
        transition: 0.3s;
    }
    .btn-link-ref:hover {
        background: #0d6efd;
        color: white;
    }

    .btn-primary-pro {
        background: var(--student-grad);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
    }
    .btn-primary-pro:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
        color: white;
    }
</style>

<div class="container-fluid py-4 fade-in">
    
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success rounded-pill border-0 shadow-sm mb-4 animate__animated animate__bounceIn">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="header-banner d-flex align-items-center justify-content-between overflow-hidden position-relative">
                <div style="z-index: 2;">
                    <h2 class="fw-bold mb-1"><i class="fas fa-tasks me-2"></i>Daftar Tugas Kelas</h2>
                    <p class="mb-0 opacity-75">Tingkatkan prestasimu dengan mengerjakan tugas tepat waktu!</p>
                </div>
                <div class="d-none d-md-block opacity-25" style="position: absolute; right: 30px; bottom: -10px;">
                    <i class="fas fa-graduation-cap fa-6x text-white"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- LIST TUGAS --}}
    <div class="row g-4">
        @forelse($data_tugas as $tugas)
            @php
                $deadline = \Carbon\Carbon::parse($tugas->deadline);
                $sekarang = \Carbon\Carbon::now();
                $sisa_hari = $sekarang->diffInDays($deadline, false); 
                
                if ($sisa_hari < 0) {
                    $badge_color = 'bg-danger';
                    $status_text = 'Sudah Lewat';
                } elseif ($sisa_hari <= 2) {
                    $badge_color = 'bg-warning text-dark';
                    $status_text = 'Hampir Deadline';
                } else {
                    $badge_color = 'bg-success';
                    $status_text = 'Masih Aktif';
                }
            @endphp

            <div class="col-md-6 col-lg-4">
                <div class="card-pro p-4 h-100 d-flex flex-column">
                    
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="task-icon">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <span class="badge {{ $badge_color }} rounded-pill px-3 py-2 shadow-sm">
                            {{ $status_text }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <small class="text-primary fw-bold text-uppercase" style="letter-spacing: 1px;">{{ $tugas->mapel }}</small>
                        <h5 class="fw-bold mb-2 text-dark">{{ $tugas->judul_tugas }}</h5>
                        <p class="text-muted small" style="display: -webkit-box; -webkit-line-clamp: 3; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $tugas->deskripsi ?? 'Klik tombol kumpulkan untuk melihat detail.' }}
                        </p>
                    </div>

                    {{-- FILE & LINK DARI GURU --}}
                    <div class="mb-4">
                        @if($tugas->link)
                            <a href="{{ $tugas->link }}" target="_blank" class="btn btn-sm btn-link-ref w-100 mb-2 fw-bold rounded-pill">
                                <i class="fas fa-link me-2"></i> Tautan Referensi
                            </a>
                        @endif

                        @if($tugas->file_lampiran)
                            @php
                                $ext = strtolower(pathinfo($tugas->file_lampiran, PATHINFO_EXTENSION));
                                $is_image = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
                            @endphp
                            
                            <a href="{{ asset('storage/uploads/tugas/'.$tugas->file_lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100 fw-bold rounded-pill">
                                <i class="fas {{ $is_image ? 'fa-image' : 'fa-file-download' }} me-2"></i> 
                                {{ $is_image ? 'Lihat Gambar Soal' : 'Download Lampiran' }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-auto pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> Deadline:</small>
                            <span class="small fw-bold {{ $sisa_hari < 0 ? 'text-danger' : 'text-dark' }}">
                                {{ $deadline->translatedFormat('d M Y, H:i') }}
                            </span>
                        </div>

                        @php
                            $cek_kumpul = \App\Models\PengumpulanTugas::where('tugas_id', $tugas->id)
                                            ->where('nis', Auth::guard('siswa')->user()->nis)
                                            ->first();
                        @endphp

                        @if($cek_kumpul)
                            @if($cek_kumpul->nilai !== null)
                                <div class="bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3 p-2 text-center">
                                    <small class="text-success fw-bold d-block">Nilai Kamu:</small>
                                    <h4 class="fw-bold text-success mb-0">{{ $cek_kumpul->nilai }} / 100</h4>
                                </div>
                            @else
                                <button class="btn btn-secondary w-100 rounded-pill fw-bold" disabled>
                                    <i class="fas fa-check-double me-2"></i> Sudah Dikumpulkan
                                </button>
                            @endif
                        @else
                            <button type="button" class="btn btn-primary-pro w-100 rounded-pill fw-bold py-2" data-bs-toggle="modal" data-bs-target="#modalKumpul{{ $tugas->id }}">
                                <i class="fas fa-upload me-2"></i> Kumpulkan Tugas
                            </button>
                        @endif
                    </div>
                </div> 

                {{-- MODAL UPLOAD DENGAN MULTIPLE FILE & KOMENTAR --}}
                <div class="modal fade" id="modalKumpul{{ $tugas->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                            <div class="modal-header border-0 bg-light" style="border-radius: 20px 20px 0 0;">
                                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-cloud-upload-alt text-primary me-2"></i>Kirim Jawaban</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <form action="{{ route('siswa.tugas.kumpul', $tugas->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    {{-- MULTIPLE FILE UPLOAD --}}
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark small">Lampirkan File Jawaban (Bisa pilih banyak)</label>
                                        <div class="p-4 rounded-3 border-2 text-center" style="border: 2px dashed #0d6efd; background: #f0f7ff;">
                                            <i class="fas fa-file-upload fa-3x text-primary mb-3"></i>
                                            <input type="file" name="file_jawaban[]" class="form-control bg-white" multiple required>
                                            <small class="text-muted d-block mt-2">Format: PDF, JPG, PNG, DOC (Max 5MB)</small>
                                        </div>
                                    </div>

                                    {{-- KOLOM KOMENTAR --}}
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark small"><i class="fas fa-comment-dots text-primary me-1"></i> Komentar untuk Guru</label>
                                        <textarea name="komentar" class="form-control" rows="3" placeholder="Tulis pesan atau kendala pengerjaan di sini (opsional)..." style="border-radius: 12px; background-color: #f8fafc; border: 1px solid #e2e8f0;"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary-pro w-100 rounded-pill fw-bold py-2">
                                        Kirim Sekarang <i class="fas fa-paper-plane ms-2"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div> 

        @empty
            <div class="col-12 text-center py-5">
                <img src="https://illustrations.popsy.co/blue/happy-boy.svg" width="200" class="mb-3">
                <h4 class="fw-bold text-dark">Belum ada tugas untukmu</h4>
                <p class="text-muted">Nikmati waktu luangmu atau ulangi pelajaran hari ini!</p>
            </div>
        @endforelse
    </div>
</div>
@endsection