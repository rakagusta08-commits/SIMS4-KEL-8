@extends('layouts.master')

@section('title', 'Tambah Tugas Kelas')

@section('content')
<style>
    .card-pro { 
        border: none; 
        border-radius: 20px; 
        overflow: hidden;
    }
    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        background-color: #f8f9fa;
        transition: 0.3s;
    }
    .form-control:focus, .form-select:focus {
        background-color: #ffffff;
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    .upload-box {
        border: 2px dashed #0d6efd;
        background-color: rgba(13, 110, 253, 0.05);
        border-radius: 15px;
        padding: 20px;
        text-align: center;
    }
    /* Efek hover pada tombol agar lebih hidup */
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }
</style>

<div class="container-fluid py-4 animate__animated animate__fadeIn">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-pro shadow-lg">
                {{-- HEADER CARD PREMIUM --}}
                <div class="card-header border-0 p-4" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                    <h4 class="fw-bold mb-0 text-white"><i class="fas fa-plus-circle me-2"></i>Buat Tugas Baru</h4>
                    <p class="text-white-50 mb-0 small mt-1">
                        Mengirim tugas untuk kelas: <strong>{{ $kelas_aktif->nama_kelas ?? 'Umum' }}</strong>
                    </p>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('tugas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted"><i class="fas fa-book text-primary me-1"></i> Mata Pelajaran</label>
                                <input type="text" name="mapel" class="form-control @error('mapel') is-invalid @enderror" placeholder="Contoh: Pemrograman Web" value="{{ old('mapel') }}" required>
                                @error('mapel') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted"><i class="fas fa-heading text-primary me-1"></i> Judul Tugas</label>
                                <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" placeholder="Contoh: Membuat CRUD Laravel" value="{{ old('judul') }}" required>
                                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted"><i class="fas fa-users text-primary me-1"></i> Kelas Target (Otomatis)</label>
                                {{-- 💡 Input kelas dibuat readonly agar sesuai dengan kelas yang dibuka --}}
                                <input type="text" name="kelas" class="form-control bg-light fw-bold text-primary" 
                                       value="{{ $kelas_aktif->nama_kelas ?? '' }}" readonly required>
                                <div class="form-text small">Tugas akan dikirim ke kelas yang aktif saat ini.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted"><i class="fas fa-clock text-danger me-1"></i> Batas Waktu (Deadline)</label>
                                <input type="datetime-local" name="deadline" class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline') }}" required>
                                @error('deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted"><i class="fas fa-align-left text-primary me-1"></i> Deskripsi / Instruksi Tugas</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="5" placeholder="Tuliskan detail instruksi tugas dengan jelas di sini..." required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- 🚀 FITUR BARU: INPUT TAUTAN / LINK --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted"><i class="fas fa-link text-info me-1"></i> Tautan / Link Referensi (Opsional)</label>
                            <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" placeholder="Contoh: https://youtube.com/..." value="{{ old('link') }}">
                            <div class="form-text small">Sertakan link referensi seperti video YouTube, artikel, atau Google Drive jika ada.</div>
                            @error('link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- 🚀 FITUR BARU: UPDATE NAMA INPUT & FORMAT GAMBAR --}}
                        <div class="mb-5">
                            <label class="form-label fw-bold small text-muted"><i class="fas fa-paperclip text-success me-1"></i> Lampirkan File atau Gambar (Opsional)</label>
                            <div class="upload-box">
                                <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                                {{-- Name diubah menjadi file_lampiran dan accept ditambah format gambar --}}
                                <input type="file" name="file_lampiran" class="form-control bg-white @error('file_lampiran') is-invalid @enderror" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.png,.jpg,.jpeg,.gif">
                                <div class="form-text small mt-2">Format yang diizinkan: <b>PDF, DOC, ZIP, serta Gambar (JPG/PNG/GIF)</b> (Maksimal 5MB).</div>
                                @error('file_lampiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('tugas.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">
                                <i class="fas fa-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow fw-bold">
                                Posting Tugas <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection