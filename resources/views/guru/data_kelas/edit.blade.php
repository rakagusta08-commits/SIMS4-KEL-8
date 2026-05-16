@extends('layouts.master')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Edit Data Kelas</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
            @csrf
            @method('PUT') <div class="mb-3">
                <label>Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control" value="{{ $kelas->nama_kelas }}" required>
            </div>

            <div class="mb-3">
                <label>Kompetensi Keahlian</label>
                <input type="text" name="kompetensi_keahlian" class="form-control" value="{{ $kelas->kompetensi_keahlian }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Data</button>
            <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection