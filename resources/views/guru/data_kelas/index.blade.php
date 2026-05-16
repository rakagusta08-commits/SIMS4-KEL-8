@extends('layouts.master')

@section('title', 'Data Kelas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold text-primary">Daftar Kelas</h5>
                    <a href="{{ route('kelas.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Kelas Baru
                    </a>
                </div>

                {{-- Search Form --}}
                <div class="card-body border-bottom p-3">
                    <form action="{{ route('kelas.index') }}" method="GET" class="d-flex gap-2">
                        <div class="flex-grow-1">
                            <div class="input-group" style="border-radius: 8px; overflow: hidden;">
                                <span class="input-group-text bg-white border-0">
                                    <i class="fas fa-search" style="color: #6366f1;"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-0" 
                                       placeholder="Cari berdasarkan nama kelas atau kompetensi keahlian..." 
                                       value="{{ $search ?? '' }}">
                            </div>
                        </div>
                        <button type="submit" class="btn fw-bold rounded-pill" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border: none;">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                        @if($search)
                            <a href="{{ route('kelas.index') }}" class="btn fw-bold rounded-pill" style="background: #e5e7eb; color: #374151; border: none;">
                                <i class="fas fa-times me-1"></i> Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Kelas</th>
                                    <th>Kompetensi Keahlian</th>
                                    <th width="200">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data_kelas as $kelas)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="badge bg-info text-dark">{{ $kelas->nama_kelas }}</span></td>
                                    <td>{{ $kelas->kompetensi_keahlian }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('kelas.edit', $kelas->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Data kelas belum tersedia.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection