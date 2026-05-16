@extends('layouts.master')

@section('title', 'Data Siswa')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 px-3 px-md-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h5 class="mb-0 fw-bold text-primary">Daftar Siswa</h5>
        <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus me-1"></i> Tambah Siswa
        </a>
    </div>

    {{-- Search Form --}}
    <div class="card-body border-bottom p-3 px-md-4">
        <form action="{{ route('siswa.index') }}" method="GET" class="d-flex gap-2">
            <div class="flex-grow-1">
                <div class="input-group" style="border-radius: 8px; overflow: hidden;">
                    <span class="input-group-text bg-white border-0">
                        <i class="fas fa-search" style="color: #6366f1;"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0" 
                           placeholder="Cari berdasarkan nama siswa, NIS, atau kelas..." 
                           value="{{ $search ?? '' }}">
                </div>
            </div>
            <button type="submit" class="btn fw-bold rounded-pill" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border: none;">
                <i class="fas fa-search me-1"></i> Cari
            </button>
            @if($search)
                <a href="{{ route('siswa.index') }}" class="btn fw-bold rounded-pill" style="background: #e5e7eb; color: #374151; border: none;">
                    <i class="fas fa-times me-1"></i> Reset
                </a>
            @endif
        </form>
    </div>

    <div class="card-body p-3 px-md-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-nowrap">
                <thead class="table-light text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">NIS</th>
                        <th>Nama Siswa</th>
                        <th width="15%">Kelas</th>
                        <th width="10%">L/P</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop data siswa --}}
                    @forelse($data_siswa as $siswa)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center fw-bold text-dark">{{ $siswa->nis }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-weight: bold; font-size: 0.8rem;">
                                    {{ strtoupper(substr($siswa->nama_siswa, 0, 1)) }}
                                </div>
                                <span class="fw-semibold">{{ $siswa->nama_siswa }}</span>
                            </div>
                        </td>
                        <td class="text-center"><span class="badge bg-info text-dark">{{ $siswa->kelas }}</span></td>
                        <td class="text-center">
                            <span class="badge {{ $siswa->jenkel == 'L' ? 'bg-primary' : 'bg-danger' }}">
                                {{ $siswa->jenkel }}
                            </span>
                        </td>
                        <td class="text-center">
                            {{-- TOMBOL EDIT (INI BAGIAN PENTINGNYA) --}}
                            {{-- Pastikan route-nya 'siswa.edit' dan mengirim ID ($siswa->id) --}}
                            <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm text-white shadow-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- TOMBOL HAPUS --}}
                            <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus data {{ $siswa->nama_siswa }}?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fas fa-folder-open fa-3x mb-3 d-block opacity-50"></i>
                            Belum ada data siswa.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection