@extends('layouts.master')

@section('title', 'Edit Data Siswa')

@section('content')
<style>
    .modern-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border-radius: 15px 15px 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .card-header-modern h4 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .card-header-modern i {
        font-size: 24px;
        margin-right: 12px;
    }
    
    .form-group-modern {
        margin-bottom: 20px;
    }
    
    .form-label-modern {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-control-modern,
    .form-select-modern {
        border: 2px solid #e0e6ed;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .form-control-modern:focus,
    .form-select-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .form-control-modern::placeholder {
        color: #aaa;
    }
    
    .btn-modern-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        color: white;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .btn-modern-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .btn-modern-secondary {
        background: #f0f2f5;
        border: 2px solid #e0e6ed;
        border-radius: 8px;
        color: #2c3e50;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-modern-secondary:hover {
        background: #e0e6ed;
        border-color: #667eea;
        color: #667eea;
    }
    
    .alert-modern {
        border: none;
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 20px;
    }
    
    .alert-danger-modern {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .alert-danger-modern strong {
        font-weight: 700;
    }
    
    .alert-danger-modern ul {
        list-style: none;
        padding-left: 0;
    }
    
    .alert-danger-modern li {
        margin: 5px 0;
        display: flex;
        align-items: center;
    }
    
    .alert-danger-modern li:before {
        content: "✓ ";
        margin-right: 8px;
        font-weight: bold;
    }
    
    .btn-close-modern {
        background: rgba(255,255,255,0.3);
        border: none;
        color: white;
    }
    
    .btn-close-modern:hover {
        background: rgba(255,255,255,0.5);
    }
    
    .form-section-title {
        font-size: 14px;
        font-weight: 700;
        color: #667eea;
        margin-top: 25px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e0e6ed;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .card-body-modern {
        padding: 30px;
        background: white;
    }
    
    .form-row-modern {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card modern-card shadow-lg">
            <div class="card-header-modern">
                <h4>
                    <i class="fas fa-user-edit"></i> Edit Data Siswa
                </h4>
            </div>
            
            <div class="card-body-modern">
                
                @if ($errors->any())
                    <div class="alert-modern alert-danger-modern alert-dismissible fade show" role="alert">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>⚠️ Validasi Gagal!</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="btn-close btn-close-modern" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-section-title">
                        <i class="fas fa-info-circle"></i> Informasi Dasar
                    </div>
                    
                    <div class="form-row-modern">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Nomor Induk Siswa (NIS)</label>
                            <input type="number" name="nis" class="form-control form-control-modern" 
                                   value="{{ old('nis', $siswa->nis) }}" placeholder="Masukkan NIS" required>
                        </div>
                        
                        <div class="form-group-modern">
                            <label class="form-label-modern">Nama Lengkap</label>
                            <input type="text" name="nama_siswa" class="form-control form-control-modern" 
                                   value="{{ old('nama_siswa', $siswa->nama_siswa) }}" placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>

                    <div class="form-section-title">
                        <i class="fas fa-graduation-cap"></i> Data Akademik
                    </div>

                    <div class="form-row-modern">
                        <div class="form-group-modern">
                            <label class="form-label-modern">Kelas</label>
                            <select name="kelas" class="form-select form-select-modern" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($data_kelas as $k)
                                    <option value="{{ $k->nama_kelas }}" 
                                            {{ $siswa->kelas == $k->nama_kelas ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-modern">
                            <label class="form-label-modern">Jenis Kelamin</label>
                            <select name="jenkel" class="form-select form-select-modern" required>
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ $siswa->jenkel == 'L' ? 'selected' : '' }}>
                                    <i class="fas fa-mars"></i> Laki-laki
                                </option>
                                <option value="P" {{ $siswa->jenkel == 'P' ? 'selected' : '' }}>
                                    <i class="fas fa-venus"></i> Perempuan
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-section-title">
                        <i class="fas fa-map-marker-alt"></i> Alamat
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control form-control-modern" rows="4" 
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat', $siswa->alamat) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-5 gap-3">
                        <a href="{{ route('siswa.index') }}" class="btn btn-modern-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-modern-primary">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection