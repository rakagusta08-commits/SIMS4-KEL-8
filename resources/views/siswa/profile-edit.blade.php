<!-- filepath: /Users/mac/sim_sekolah_beta/resources/views/siswa/profil-edit.blade.php -->
@extends('layouts.master')

@section('title', 'Edit Profil - SIM SEKOLAH')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --student-grad: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
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

    .avatar-wrapper {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: #fff;
        padding: 5px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        margin: 0 auto 20px;
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

    .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid #e9ecef;
        padding: 12px 16px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .form-label {
        font-weight: 600;
        color: #2b3445;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-text {
        font-size: 0.85rem;
        color: #adb5bd;
    }

    .btn-primary {
        background: var(--student-grad);
        border: none;
        border-radius: 50rem;
        padding: 12px 32px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
    }

    .btn-outline-secondary {
        border-radius: 50rem;
        padding: 12px 32px;
        font-weight: 600;
        border: 2px solid #e9ecef;
        color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }

    .file-input-wrapper {
        position: relative;
    }

    .file-input-wrapper input[type="file"] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-input-label {
        display: block;
        padding: 12px 16px;
        background-color: #f8f9fa;
        border: 2px dashed #0d6efd;
        border-radius: 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-input-label:hover {
        background-color: #e7f1ff;
        border-color: #0043a8;
    }

    .alert-custom {
        border-radius: 15px;
        border: none;
        padding: 20px;
    }

    .info-box {
        background: linear-gradient(135deg, #0d6efd15 0%, #0043a815 100%);
        border-left: 5px solid #0d6efd;
        border-radius: 12px;
        padding: 16px;
        margin-top: 20px;
    }
</style>

<div class="container-fluid py-4 fade-in">
    
    <div class="row mb-4 align-items-center">
        <div class="col-12">
            <h3 class="fw-bold text-dark mb-0"><i class="fas fa-edit text-primary me-2"></i>Edit Profil Saya</h3>
            <p class="text-muted">Perbarui informasi data diri dan biografi Anda</p>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-custom alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Alert Error --}}
    @if($errors->any())
        <div class="alert alert-danger alert-custom alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Ada kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('siswa.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- KOLOM KIRI: FOTO PROFIL --}}
            <div class="col-lg-4">
                <div class="card card-pro bg-white">
                    <div class="card-body p-4 text-center">
                        <h6 class="fw-bold text-dark mb-4"><i class="fas fa-image text-primary me-2"></i>Foto Profil</h6>
                        
                        {{-- Preview Foto --}}
                        <div class="avatar-wrapper">
                            @if($siswa->foto_profil)
                                <img id="fotoPreview" src="{{ asset('storage/uploads/profil/'.$siswa->foto_profil) }}" 
                                    class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                @php
                                    $inisial = strtoupper(substr($siswa->nama_siswa ?? $siswa->nama ?? 'S', 0, 2));
                                @endphp
                                <div class="avatar-circle" id="avatarDefault">
                                    {{ $inisial }}
                                </div>
                            @endif
                        </div>

                        {{-- File Input --}}
                        <div class="file-input-wrapper mb-3">
                            <label for="fotoProfil" class="file-input-label">
                                <i class="fas fa-cloud-upload-alt me-2" style="font-size: 1.5rem;"></i>
                                <div class="fw-bold text-primary">Pilih Foto</div>
                                <small class="text-muted d-block mt-1">JPG, PNG, GIF (Max 2MB)</small>
                            </label>
                            <input type="file" class="form-control" id="fotoProfil" name="foto_profil" accept="image/*">
                        </div>

                        @error('foto_profil')
                            <div class="alert alert-danger alert-sm py-2 px-3 rounded-2 small">
                                {{ $message }}
                            </div>
                        @enderror

                        <small class="text-muted d-block">
                            <i class="fas fa-info-circle me-1"></i>Klik area di atas untuk memilih foto baru
                        </small>
                    </div>
                </div>

                {{-- Info Box --}}
                <div class="info-box mt-4">
                    <h6 class="fw-bold text-dark mb-2"><i class="fas fa-lightbulb text-warning me-2"></i>Tips Foto Profil</h6>
                    <ul class="small text-muted mb-0" style="padding-left: 20px;">
                        <li>Gunakan foto yang jelas dan profesional</li>
                        <li>Wajah terlihat dengan jelas</li>
                        <li>Background simpel dan rapi</li>
                        <li>Ukuran file tidak terlalu besar</li>
                    </ul>
                </div>
            </div>

            {{-- KOLOM KANAN: FORM DATA --}}
            <div class="col-lg-8">
                <div class="card card-pro bg-white">
                    <div class="card-body p-4">
                        
                        {{-- TAB 1: DATA DIRI --}}
                        <h6 class="fw-bold text-dark mb-4"><i class="fas fa-info-circle text-primary me-2"></i>Data Diri (Read Only)</h6>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ $siswa->nama_siswa ?? $siswa->nama ?? '-' }}" readonly style="background-color: #f8f9fa;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIS (Nomor Induk Siswa)</label>
                                <input type="text" class="form-control" value="{{ $siswa->nis ?? '-' }}" readonly style="background-color: #f8f9fa;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kelas</label>
                                <input type="text" class="form-control" value="{{ $siswa->kelas ?? '-' }}" readonly style="background-color: #f8f9fa;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ $siswa->email ?? '-' }}" readonly style="background-color: #f8f9fa;">
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- TAB 2: DATA PRIBADI (EDITABLE) --}}
                        <h6 class="fw-bold text-dark mb-4"><i class="fas fa-user text-success me-2"></i>Data Pribadi</h6>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                    name="tanggal_lahir" value="{{ $siswa->tanggal_lahir }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" 
                                    name="no_telepon" placeholder="08xxxxxxxxxx" value="{{ $siswa->no_telepon }}">
                                @error('no_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                    name="alamat" rows="3" placeholder="Masukkan alamat lengkap Anda">{{ $siswa->alamat }}</textarea>
                                <small class="form-text">Contoh: Jl. Merdeka No. 123, Kelurahan X, Kecamatan Y, Kota Bandung</small>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- TAB 3: BIOGRAFI --}}
                        <h6 class="fw-bold text-dark mb-4"><i class="fas fa-pen-fancy text-info me-2"></i>Biografi</h6>

                        <div class="mb-4">
                            <label class="form-label">Ceritakan Tentang Diri Anda</label>
                            <textarea class="form-control @error('biografi') is-invalid @enderror" 
                                name="biografi" rows="5" placeholder="Tuliskan biografi singkat Anda, minat, hobby, atau pencapaian yang ingin Anda bagikan...">{{ $siswa->biografi }}</textarea>
                            <small class="form-text">Maksimal 500 karakter</small>
                            @error('biografi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="info-box">
                            <h6 class="fw-bold text-dark mb-2"><i class="fas fa-lightbulb text-warning me-2"></i>Tips Biografi</h6>
                            <ul class="small text-muted mb-0" style="padding-left: 20px;">
                                <li>Tulis dengan ringkas dan menarik</li>
                                <li>Ceritakan hal unik atau menarik tentang Anda</li>
                                <li>Sebutkan minat atau hobi Anda</li>
                                <li>Jangan lupa pastikan data akurat dan positif</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex gap-3 justify-content-end">
                    <a href="{{ route('siswa.profil') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>

<script>
    // Preview Foto
    document.getElementById('fotoProfil').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validasi ukuran file
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('fotoPreview');
                const avatarDefault = document.getElementById('avatarDefault');
                
                // Hapus avatar default jika ada
                if (avatarDefault) {
                    avatarDefault.style.display = 'none';
                }

                // Buat img jika belum ada
                if (!preview || preview.tagName !== 'IMG') {
                    const img = document.createElement('img');
                    img.id = 'fotoPreview';
                    img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; border-radius: 50%;';
                    document.querySelector('.avatar-wrapper').innerHTML = '';
                    document.querySelector('.avatar-wrapper').appendChild(img);
                    img.src = event.target.result;
                } else {
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // Validasi form
    document.querySelector('form').addEventListener('submit', function(e) {
        const bioLength = document.querySelector('textarea[name="biografi"]').value.length;
        if (bioLength > 500) {
            e.preventDefault();
            alert('Biografi maksimal 500 karakter!');
        }
    });
</script>

@endsection