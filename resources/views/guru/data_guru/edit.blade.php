@extends('layouts.master')

@section('title', 'Edit Data Guru')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-warning text-dark py-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i>Edit Data Guru</h5>
    </div>
    <div class="card-body p-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guru.update', $guru->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">NIP</label>
                <input type="text" name="nip" class="form-control" value="{{ $guru->nip }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nama Guru</label>
                <input type="text" name="nama_guru" class="form-control" value="{{ $guru->nama_guru }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Mata Pelajaran</label>
                <input type="text" name="mata_pelajaran" class="form-control" value="{{ $guru->mata_pelajaran }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Role / Hak Akses</label>
                <select name="role" class="form-control" required>
                    <option value="admin" {{ $guru->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guru_mapel" {{ $guru->role == 'guru_mapel' ? 'selected' : '' }}>Guru Mapel</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary px-4">Update Data</button>
            <a href="{{ route('guru.index') }}" class="btn btn-secondary px-4">Batal</a>
        </form>
    </div>
</div>
@endsection