@extends('layouts.master')

@section('title', 'Tambah Siswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Tambah Siswa Baru</h5>
            </div>
            <div class="card-body">
                
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal Menyimpan!</strong> Cek kesalahan berikut:
                        <ul class="mb-0 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('siswa.store') }}" method="POST">
                    @csrf 
                    
                    {{-- 1. NIS --}}
                    <div class="mb-3">
                        <label class="fw-bold">NIS (Nomor Induk Siswa)</label>
                        <input type="number" name="nis" class="form-control" required placeholder="Contoh: 102938" value="{{ old('nis') }}">
                    </div>

                    {{-- 2. NAMA --}}
                    <div class="mb-3">
                        <label class="fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama_siswa" class="form-control" required placeholder="Masukkan nama siswa" value="{{ old('nama_siswa') }}">
                    </div>

                    {{-- 3. PASSWORD (INI YANG SAYA TAMBAHKAN) --}}
                    <div class="mb-3">
                        <label class="fw-bold text-primary">Password Akun</label>
                        {{-- name="password" sesuai dengan Controller --}}
                        <input type="text" name="password" class="form-control" required placeholder="Masukkan password (misal: siswa123)">
                        <small class="text-muted">Password ini wajib diisi agar siswa bisa login.</small>
                    </div>

                    {{-- 4. KELAS & GENDER --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Kelas</label>
                            <select name="kelas" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                <option value="10 RPL" {{ old('kelas') == '10 RPL' ? 'selected' : '' }}>10 RPL</option>
                                <option value="11 RPL" {{ old('kelas') == '11 RPL' ? 'selected' : '' }}>11 RPL</option>
                                <option value="12 RPL" {{ old('kelas') == '12 RPL' ? 'selected' : '' }}>12 RPL</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Jenis Kelamin</label>
                            <select name="jenkel" class="form-select" required>
                                <option value="">-- Pilih Gender --</option>
                                <option value="L" {{ old('jenkel') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenkel') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    {{-- 5. ALAMAT --}}
                    <div class="mb-3">
                        <label class="fw-bold">Alamat (Opsional)</label>
                        <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection