@extends('layouts.master')

@section('title', 'Jadwal Pelajaran Saya')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-1"><i class="fas fa-calendar-alt me-2"></i>Jadwal Pelajaran</h4>
                    <p class="mb-0 opacity-75">Berikut adalah jadwal pelajaran kelas kamu.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th class="py-3 px-4">HARI</th>
                                    <th class="py-3 px-4">MATA PELAJARAN</th>
                                    <th class="py-3 px-4">GURU PENGAJAR</th>
                                    <th class="py-3 px-4">JAM KE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwal as $j)
                                    <tr>
                                        <td class="px-4 fw-bold">
                                            @if($j->hari == 'Senin')
                                                <span class="badge bg-danger">{{ $j->hari }}</span>
                                            @elseif($j->hari == 'Selasa')
                                                <span class="badge bg-warning text-dark">{{ $j->hari }}</span>
                                            @elseif($j->hari == 'Rabu')
                                                <span class="badge bg-info text-dark">{{ $j->hari }}</span>
                                            @elseif($j->hari == 'Kamis')
                                                <span class="badge bg-primary">{{ $j->hari }}</span>
                                            @elseif($j->hari == 'Jumat')
                                                <span class="badge bg-success">{{ $j->hari }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $j->hari }}</span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-4 fw-bold text-dark">{{ $j->mata_pelajaran }}</td>
                                        <td class="px-4 text-muted">{{ $j->guru->nama_guru ?? 'Guru Tidak Ditemukan' }}</td>
                                        <td class="px-4">
                                            <span class="badge bg-light text-dark border border-secondary">
                                                {{ $j->jam_mulai }} - {{ $j->jam_selesai }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fas fa-calendar-times fa-3x mb-3 text-secondary opacity-50"></i>
                                            <p class="mb-0">Belum ada jadwal pelajaran untuk kelas kamu.</p>
                                        </td>
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