@extends('layouts.master')
@section('title', 'Data Guru')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-primary">Daftar Guru</h5>
        <a href="{{ route('guru.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus me-1"></i> Tambah Guru
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-md-5">
                <form action="{{ route('guru.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari Nama atau NIP Guru..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('guru.index') }}" class="btn btn-danger">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">NIP</th>
                        <th>Nama Guru</th>
                        <th width="25%">Mata Pelajaran</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data_guru as $guru)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center fw-bold">{{ $guru->nip }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-info text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                    {{ strtoupper(substr($guru->nama_guru, 0, 1)) }}
                                </div>
                                {{ $guru->nama_guru }}
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $guru->mata_pelajaran }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-sm btn-warning text-white shadow-sm" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus data Guru {{ $guru->nama_guru }}?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            @if(request('search'))
                                Pencarian "<b>{{ request('search') }}</b>" tidak ditemukan.
                            @else
                                Belum ada data guru.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 