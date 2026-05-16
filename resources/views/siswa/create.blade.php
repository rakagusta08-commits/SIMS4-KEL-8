@extends('layouts.master')
@section('content')
<div class="container">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white">Tambah Tugas Baru</div>
        <div class="card-body">
            <form action="{{ route('tugas.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Mata Pelajaran</label>
                    <input type="text" name="mapel" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Judul Tugas</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Untuk Kelas</label>
                    <select name="kelas" class="form-select">
                        @foreach($data_kelas as $k)
                        <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Deadline</label>
                    <input type="date" name="deadline" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Deskripsi Tugas</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Tugas</button>
            </form>
        </div>
    </div>
</div>
@endsection