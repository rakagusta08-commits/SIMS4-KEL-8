@extends('layouts.master')

@section('title', 'Edit Tugas')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0 text-warning">Edit Tugas Siswa</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('tugas.update', $tugas->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Mata Pelajaran</label>
                                <input type="text" name="mapel" class="form-control" value="{{ $tugas->mapel }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Judul Tugas</label>
                                <input type="text" name="judul" class="form-control" value="{{ $tugas->judul_tugas }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Pilih Kelas</label>
                                <select name="kelas" class="form-select" required>
                                    @foreach($data_kelas as $k)
                                        <option value="{{ $k->nama_kelas }}" {{ $tugas->kelas == $k->nama_kelas ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Deadline</label>
                                <input type="date" name="deadline" class="form-control" value="{{ $tugas->deadline->format('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Deskripsi Tugas</label>
                            <textarea name="deskripsi" class="form-control" rows="5" required>{{ $tugas->deskripsi }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tugas.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-warning text-white px-5 shadow-sm">Update Tugas <i class="fas fa-save ms-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection