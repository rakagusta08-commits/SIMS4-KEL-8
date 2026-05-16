@extends('layouts.master')
@section('title', 'Tambah Guru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form Tambah Guru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('guru.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>NIP (Nomor Induk Pegawai)</label>
                        <input type="number" name="nip" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_guru" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Mata Pelajaran</label>
                        <input type="text" name="mata_pelajaran" class="form-control" placeholder="Contoh: Matematika">
                    </div>
                    <div class="mb-3">
                        <label>Password Login</label>
                        <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection