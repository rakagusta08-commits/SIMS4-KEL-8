@extends('layouts.master')

@section('title', 'Manajemen Tugas Kelas - SIM SEKOLAH')

@section('content')
<style>
    .card-pro { 
        border: none; 
        border-radius: 20px; 
        transition: 0.3s cubic-bezier(.25,.8,.25,1); 
    }
    .card-pro:hover { 
        box-shadow: 0 15px 35px rgba(0,0,0,0.08); 
    }
    .table-hover tbody tr:hover { 
        background-color: rgba(37, 99, 235, 0.03); 
    }
    /* Animasi teks mengalir jika kepanjangan */
    .text-truncate-custom {
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<div class="container-fluid py-4 animate__animated animate__fadeIn">
    
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center rounded-4 border-0 shadow-sm mb-4 animate__animated animate__lightSpeedInLeft">
            <i class="fas fa-check-circle me-3 fs-4"></i> 
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-0"><i class="fas fa-tasks text-primary me-2"></i>Manajemen Tugas</h3>
            <p class="text-muted mb-0">
                @if(session('nama_kelas_aktif'))
                    Menampilkan daftar tugas untuk kelas <span class="badge bg-primary bg-opacity-10 text-primary fw-bold">{{ session('nama_kelas_aktif') }}</span>
                @else
                    Kelola tugas yang diberikan ke siswa dan periksa jawabannya.
                @endif
            </p>
        </div>
        <div class="d-flex gap-2">
            {{-- Tombol Pindah Kelas jika ingin cepat keluar --}}
            @if(session('id_kelas_aktif'))
                <a href="{{ route('guru.pilih-kelas') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">
                    <i class="fas fa-exchange-alt me-2"></i> Pindah Kelas
                </a>
            @endif
            <a href="{{ route('tugas.create') }}" class="btn btn-primary rounded-pill shadow px-4 py-2 fw-bold">
                <i class="fas fa-plus me-2"></i> Buat Tugas Baru
            </a>
        </div>
    </div>

    {{-- TABEL DAFTAR TUGAS --}}
    <div class="card card-pro shadow-sm border-0 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4 text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">Info Tugas</th>
                            <th class="py-3 text-center text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">Kelas</th>
                            <th class="py-3 text-center text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">Deadline</th>
                            <th class="py-3 text-center text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tugas as $t)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-bold text-dark fs-6 text-truncate-custom">{{ $t->judul_tugas }}</div>
                                <div class="d-flex gap-2 mt-1">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10">{{ $t->mapel }}</span>
                                    @if($t->file_tugas)
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10">
                                            <i class="fas fa-paperclip me-1"></i> File Lampiran
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill fw-bold">{{ $t->kelas }}</span>
                            </td>
                            <td class="text-center">
                                @php
                                    $deadline = \Carbon\Carbon::parse($t->deadline);
                                    $is_past = \Carbon\Carbon::now()->gt($deadline);
                                @endphp
                                <div class="d-flex flex-column align-items-center">
                                    <span class="badge {{ $is_past ? 'bg-danger' : 'bg-success' }} bg-opacity-10 {{ $is_past ? 'text-danger' : 'text-success' }} px-3 py-2 rounded-pill border {{ $is_past ? 'border-danger' : 'border-success' }} mb-1">
                                        <i class="fas fa-clock me-1"></i> {{ $deadline->format('d M Y') }}
                                    </div>
                                    <small class="text-muted fw-bold" style="font-size: 10px;">Pukul {{ $deadline->format('H:i') }} WIB</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    {{-- TOMBOL KOREKSI --}}
                                    <a href="{{ route('tugas.koreksi', $t->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold shadow-sm" title="Koreksi Jawaban">
                                        <i class="fas fa-edit me-1"></i> Koreksi
                                    </a>
                                    
                                    {{-- TOMBOL EDIT --}}
                                    <a href="{{ route('tugas.edit', $t->id) }}" class="btn btn-sm btn-outline-warning border rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" title="Edit">
                                        <i class="fas fa-pen fs-xs"></i>
                                    </a>

                                    {{-- TOMBOL HAPUS --}}
                                    <form action="{{ route('tugas.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus tugas ini? Data jawaban siswa juga akan hilang.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="animate__animated animate__fadeIn">
                                    <img src="https://illustrations.popsy.co/blue/no-messages-for-now.svg" width="180" class="mb-3 opacity-75">
                                    <h5 class="fw-bold text-dark">Tidak Ada Tugas di Kelas Ini</h5>
                                    <p class="text-muted">Mungkin kelas ini sedang santai, atau kamu belum membuat tugas baru.</p>
                                    <a href="{{ route('tugas.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Buat Sekarang</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection