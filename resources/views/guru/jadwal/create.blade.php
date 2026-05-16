@extends('layouts.master')
@section('title', 'Tambah Jadwal Baru')

@section('content')
<div class="card border-0 shadow-sm col-md-8 mx-auto">
    <div class="card-header bg-primary text-white py-3">
        <h5 class="mb-0 fw-bold">Form Input Jadwal</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('jadwal.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Pilih Hari</label>
                    <select name="hari" class="form-select" required>
                        <option value="">-- Pilih Hari --</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Pilih Kelas</label>
                    <select name="kelas" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($data_kelas as $k)
                            <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-control" required>
                </div>
                <div class="col-md-12 mb-4">
                    <label class="form-label fw-bold">Nama Mata Pelajaran</label>
                    <input type="text" name="mata_pelajaran" class="form-control" placeholder="Contoh: Pemrograman Web (Laravel)" required>
                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('jadwal.index') }}" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>
@endsection