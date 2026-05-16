@extends('layouts.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 24px;">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i> Edit Profil Saya</h4>
                </div>

                <div class="card-body p-4">

                    {{-- Alert Success --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Alert Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                            <strong>Validasi Error:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('siswa.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- NAMA SISWA --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="nama_siswa">
                                <i class="fas fa-user me-1"></i> Nama Siswa
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('nama_siswa') is-invalid @enderror" 
                                id="nama_siswa" 
                                name="nama_siswa" 
                                value="{{ old('nama_siswa', $siswa->nama_siswa) }}"
                                required
                                style="border-radius: 10px; padding: 12px; border: 2px solid #e5e7eb;"
                            >
                            @error('nama_siswa')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- NIS (READ-ONLY) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="nis">
                                <i class="fas fa-id-card me-1"></i> NIS
                            </label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="nis" 
                                value="{{ $siswa->nis }}"
                                disabled
                                style="border-radius: 10px; padding: 12px; background-color: #f3f4f6;"
                            >
                            <small class="text-muted">Tidak bisa diubah</small>
                        </div>

                        {{-- KELAS (READ-ONLY) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="kelas">
                                <i class="fas fa-chalkboard me-1"></i> Kelas
                            </label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="kelas" 
                                value="{{ $siswa->kelas }}"
                                disabled
                                style="border-radius: 10px; padding: 12px; background-color: #f3f4f6;"
                            >
                            <small class="text-muted">Tidak bisa diubah</small>
                        </div>

                        <hr>

                        {{-- ROW 1: TEMPAT LAHIR & TANGGAL LAHIR --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold" for="tempat_lahir">
                                    <i class="fas fa-map-marker-alt me-1"></i> Tempat Lahir
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                    id="tempat_lahir" 
                                    name="tempat_lahir" 
                                    value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                                    placeholder="Misal: Jakarta"
                                    style="border-radius: 10px; padding: 12px; border: 2px solid #e5e7eb;"
                                >
                                @error('tempat_lahir')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold" for="tanggal_lahir">
                                    <i class="fas fa-birthday-cake me-1"></i> Tanggal Lahir
                                </label>
                                <input 
                                    type="date" 
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                    id="tanggal_lahir" 
                                    name="tanggal_lahir" 
                                    value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}"
                                    style="border-radius: 10px; padding: 12px; border: 2px solid #e5e7eb;"
                                >
                                @error('tanggal_lahir')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- ROW 2: JENIS KELAMIN & AGAMA --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold" for="jenis_kelamin">
                                    <i class="fas fa-venus-mars me-1"></i> Jenis Kelamin
                                </label>
                                <select 
                                    class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                    id="jenis_kelamin" 
                                    name="jenis_kelamin"
                                    style="border-radius: 10px; padding: 12px; border: 2px solid #e5e7eb;"
                                >
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki')>Laki-laki</option>
                                    <option value="Perempuan" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan')>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold" for="agama">
                                    <i class="fas fa-praying-hands me-1"></i> Agama
                                </label>
                                <select 
                                    class="form-select @error('agama') is-invalid @enderror" 
                                    id="agama" 
                                    name="agama"
                                    style="border-radius: 10px; padding: 12px; border: 2px solid #e5e7eb;"
                                >
                                    <option value="">-- Pilih --</option>
                                    <option value="Islam" @selected(old('agama', $siswa->agama) == 'Islam')>Islam</option>
                                    <option value="Kristen" @selected(old('agama', $siswa->agama) == 'Kristen')>Kristen</option>
                                    <option value="Katolik" @selected(old('agama', $siswa->agama) == 'Katolik')>Katolik</option>
                                    <option value="Hindu" @selected(old('agama', $siswa->agama) == 'Hindu')>Hindu</option>
                                    <option value="Buddha" @selected(old('agama', $siswa->agama) == 'Buddha')>Buddha</option>
                                </select>
                                @error('agama')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        {{-- ALAMAT --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="alamat">
                                <i class="fas fa-home me-1"></i> Alamat
                            </label>
                            <textarea 
                                class="form-control @error('alamat') is-invalid @enderror" 
                                id="alamat" 
                                name="alamat" 
                                rows="3"
                                placeholder="Masukkan alamat lengkap Anda"
                                style="border-radius: 10px; padding: 12px; border: 2px solid #e5e7eb;"
                            >{{ old('alamat', $siswa->alamat) }}</textarea>
                            @error('alamat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- ROW 3: NO HP & NAMA ORANG TUA --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold" for="no_hp">
                                    <i class="fas fa-mobile-alt me-1"></i> Nomor HP
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('no_hp') is-invalid @enderror" 
                                    id="no_hp" 
                                    name="no_hp" 
                                    value="{{ old('no_hp', $siswa->no_hp) }}"
                                    placeholder="Misal: 08123456789"
                                    style="border-radius: 10px; padding: 12px; border: 2px solid #e5e7eb;"
                                >
                                @error('no_hp')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold" for="nama_ortu">
                                    <i class="fas fa-people-arrows me-1"></i> Nama Orang Tua
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('nama_ortu') is-invalid @enderror" 
                                    id="nama_ortu" 
                                    name="nama_ortu" 
                                    value="{{ old('nama_ortu', $siswa->nama_ortu) }}"
                                    placeholder="Nama ayah/ibu"
                                    style="border-radius: 10px; padding: 12px; border: 2px solid #e5e7eb;"
                                >
                                @error('nama_ortu')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        {{-- BUTTONS --}}
                        <div class="d-flex gap-2">
                            <button 
                                type="submit" 
                                class="btn flex-grow-1 py-3 fw-bold rounded-3 shadow-sm" 
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; font-size: 1rem;"
                            >
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                            <a 
                                href="{{ route('siswa.profil') }}" 
                                class="btn btn-outline-secondary py-3 fw-bold rounded-3"
                            >
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
