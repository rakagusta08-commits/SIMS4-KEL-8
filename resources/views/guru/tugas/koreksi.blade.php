@extends('layouts.master')

@section('title', 'Koreksi Tugas - SIM SEKOLAH')

@section('content')
<div class="container-fluid py-4 animate__animated animate__fadeIn">
    
    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-pill mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- HEADER TUGAS --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
        <div class="card-body p-4 bg-dark text-white" style="border-radius: 20px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-primary mb-2">{{ $tugas->mapel }}</span>
                    <h3 class="fw-bold mb-1">{{ $tugas->judul_tugas }}</h3>
                    <p class="mb-0 opacity-75"><i class="fas fa-users me-2"></i>Kelas: {{ $tugas->kelas }} | <i class="fas fa-clock me-2 ms-3"></i>Deadline: {{ date('d M Y - H:i', strtotime($tugas->deadline)) }}</p>
                </div>
                <div>
                    <a href="{{ route('tugas.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL PENGUMPULAN --}}
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
        <div class="card-header bg-white p-4 border-0">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-clipboard-check me-2 text-success"></i>Daftar Jawaban Siswa</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">NIS & Nama Siswa</th>
                            <th class="py-3 text-center">Waktu Kumpul</th>
                            <th class="py-3 text-center">File Jawaban</th>
                            <th class="py-3 text-center" width="200">Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jawaban_siswa as $jawaban)
                        <tr>
                            <td class="px-4">
                                <div class="fw-bold text-dark">{{ $jawaban->siswa->nama_siswa ?? 'Siswa (Data Terhapus)' }}</div>
                                <small class="text-muted">{{ $jawaban->nis }}</small>
                            </td>
                            <td class="text-center">
                                @php
                                    $telat = \Carbon\Carbon::parse($jawaban->created_at)->gt(\Carbon\Carbon::parse($tugas->deadline));
                                @endphp
                                <span class="badge {{ $telat ? 'bg-danger' : 'bg-success' }} bg-opacity-10 {{ $telat ? 'text-danger' : 'text-success' }} px-3 py-2 rounded-pill border {{ $telat ? 'border-danger' : 'border-success' }}">
                                    {{ $jawaban->created_at->format('d M Y, H:i') }}
                                    {!! $telat ? '<br><small>(Terlambat)</small>' : '' !!}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ asset('storage/uploads/jawaban/'.$jawaban->file_jawaban) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill fw-bold px-3">
                                    <i class="fas fa-download me-1"></i> Download
                                </a>
                            </td>
                            <td class="text-center px-4">
                                {{-- Form Input Nilai --}}
                                <form action="{{ route('tugas.nilai', $jawaban->id) }}" method="POST" class="d-flex align-items-center justify-content-center">
                                    @csrf
                                    <div class="input-group input-group-sm w-75">
                                        <input type="number" name="nilai" class="form-control text-center fw-bold" value="{{ $jawaban->nilai }}" placeholder="0-100" min="0" max="100" required>
                                        <button class="btn btn-success fw-bold" type="submit"><i class="fas fa-check"></i></button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                                <h5>Belum Ada yang Mengumpulkan</h5>
                                <p>Siswa dari kelas {{ $tugas->kelas }} belum ada yang mengirimkan jawaban.</p>
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