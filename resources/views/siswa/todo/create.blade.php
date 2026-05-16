@extends('layouts.master')

@section('title', 'Tambah To-Do | SIM SEKOLAH')

@section('content')
<style>
    :root {
        --primary: #6366f1;
        --accent: #8b5cf6;
    }

    .form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 30px;
    }

    .form-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        color: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.2);
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
        display: block;
        font-size: 1rem;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .btn-group {
        display: flex;
        gap: 15px;
        margin-top: 35px;
    }

    .btn {
        padding: 12px 30px;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: white;
        flex: 1;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
    }

    .btn-cancel {
        background: #e5e7eb;
        color: #374151;
        text-decoration: none;
        flex: 1;
        justify-content: center;
    }

    .btn-cancel:hover {
        background: #d1d5db;
    }

    .helper-text {
        font-size: 0.85rem;
        color: #64748b;
        margin-top: 5px;
    }

    .priority-info {
        background: #f0f4ff;
        border-left: 4px solid var(--primary);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h1 class="mb-1 fw-bold">✍️ Buat To-Do Baru</h1>
        <p class="opacity-75 mb-0">Kelola tugas dan prioritas dengan baik</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Oops!</strong> Ada beberapa kesalahan:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('siswa.todo.store') }}" method="POST">
        @csrf

        {{-- Judul Tugas --}}
        <div class="form-group">
            <label class="form-label" for="judul_tugas">
                <i class="fas fa-heading me-2" style="color: var(--primary);"></i>
                Judul Tugas
            </label>
            <input type="text" id="judul_tugas" name="judul_tugas" class="form-control" 
                   placeholder="Contoh: Belajar Laravel..." 
                   value="{{ old('judul_tugas') }}" required>
            <div class="helper-text">Masukkan judul tugas yang ingin dikerjakan</div>
        </div>

        {{-- Deskripsi --}}
        <div class="form-group">
            <label class="form-label" for="deskripsi">
                <i class="fas fa-align-left me-2" style="color: var(--primary);"></i>
                Deskripsi (Opsional)
            </label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" 
                      placeholder="Jelaskan detail tugas ini...">{{ old('deskripsi') }}</textarea>
            <div class="helper-text">Tambahkan catatan atau detail yang penting</div>
        </div>

        {{-- Prioritas --}}
        <div class="form-group">
            <label class="form-label" for="prioritas">
                <i class="fas fa-exclamation-triangle me-2" style="color: var(--primary);"></i>
                Prioritas
            </label>
            <select id="prioritas" name="prioritas" class="form-select" required>
                <option value="">-- Pilih Prioritas --</option>
                <option value="Rendah" {{ old('prioritas') == 'Rendah' ? 'selected' : '' }}>
                    🟦 Rendah
                </option>
                <option value="Sedang" {{ old('prioritas') == 'Sedang' ? 'selected' : '' }}>
                    🟨 Sedang
                </option>
                <option value="Tinggi" {{ old('prioritas') == 'Tinggi' ? 'selected' : '' }}>
                    🟥 Tinggi
                </option>
            </select>

            <div class="priority-info" style="margin-top: 15px;">
                <strong>Panduan Prioritas:</strong>
                <ul class="mb-0 mt-2" style="font-size: 0.9rem;">
                    <li><strong>Rendah:</strong> Tugas yang tidak mendesak</li>
                    <li><strong>Sedang:</strong> Tugas penting dengan deadline moderat</li>
                    <li><strong>Tinggi:</strong> Tugas mendesak atau deadline dekat</li>
                </ul>
            </div>
        </div>

        {{-- Deadline --}}
        <div class="form-group">
            <label class="form-label" for="deadline">
                <i class="fas fa-calendar me-2" style="color: var(--primary);"></i>
                Deadline (Opsional)
            </label>
            <input type="datetime-local" id="deadline" name="deadline" class="form-control" 
                   value="{{ old('deadline') }}">
            <div class="helper-text">Tetapkan tanggal dan jam deadline untuk pengingat</div>
        </div>

        {{-- Buttons --}}
        <div class="btn-group">
            <button type="submit" class="btn btn-submit">
                <i class="fas fa-check"></i> Simpan To-Do
            </button>
            <a href="{{ route('siswa.todo.index') }}" class="btn btn-cancel">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
