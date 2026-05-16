@extends('layouts.master')

@section('content')
<div class="container py-4 animate__animated animate__fadeIn">
    {{-- Header Rekap --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark"><i class="fas fa-history text-primary me-2"></i> Rekap Absensi</h2>
            <p class="text-muted">Kelas: <b>{{ $kelas->nama_kelas }}</b> | Tanggal: {{ $tanggal->translatedFormat('d F Y') }}</p>
        </div>
        <button onclick="window.print()" class="btn btn-outline-dark rounded-pill px-4 shadow-sm">
            <i class="fas fa-print me-2"></i> Cetak Laporan
        </button>
    </div>

    {{-- 🚀 NAVIGASI TANGGAL --}}
    <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; background: white; padding: 16px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        {{-- Tombol Kemarin --}}
        <a href="{{ route('absensi.rekap', ['kelas_id' => $kelas->id, 'tanggal' => $tanggal->copy()->subDay()->format('Y-m-d')]) }}"
           class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">
            ← Kemarin
        </a>
        
        {{-- Tombol Hari Ini --}}
        <a href="{{ route('absensi.rekap', ['kelas_id' => $kelas->id, 'tanggal' => \Carbon\Carbon::today()->format('Y-m-d')]) }}"
           class="btn btn-sm btn-primary" style="border-radius: 8px;">
            Hari Ini
        </a>
        
        {{-- Tombol Besok --}}
        <a href="{{ route('absensi.rekap', ['kelas_id' => $kelas->id, 'tanggal' => $tanggal->copy()->addDay()->format('Y-m-d')]) }}"
           class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">
            Besok →
        </a>
        
        {{-- Date Picker --}}
        <form method="GET" action="{{ route('absensi.rekap', $kelas->id) }}" style="display: flex; align-items: center; gap: 8px; margin-left: auto;">
            <label style="font-size: 0.9rem; font-weight: 500; color: #333;">Pilih Tanggal:</label>
            <input type="date" 
                   name="tanggal" 
                   value="{{ $tanggal->format('Y-m-d') }}"
                   onchange="this.form.submit()"
                   style="border: 1px solid #ddd; border-radius: 8px; padding: 6px 10px; font-size: 0.9rem;">
        </form>
    </div>

    {{-- Statistik Ringkas --}}
    <div class="row g-3 mb-4 text-center">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 bg-success text-white" style="border-radius: 20px;">
                <h3 class="fw-bold mb-0">{{ $hadir }}</h3>
                <small>Hadir</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 bg-info text-white" style="border-radius: 20px;">
                <h3 class="fw-bold mb-0">{{ $sakit }}</h3>
                <small>Sakit</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 bg-warning text-dark" style="border-radius: 20px;">
                <h3 class="fw-bold mb-0">{{ $izin }}</h3>
                <small>Izin</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 bg-danger text-white" style="border-radius: 20px;">
                <h3 class="fw-bold mb-0">{{ $alpa }}</h3>
                <small>Alpa</small>
            </div>
        </div>
    </div>

    {{-- Tabel Rekap --}}
    <div class="card border-0 shadow-sm" style="border-radius: 25px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">Nama Siswa</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-center">Foto Bukti</th>
                            <th class="py-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa_kelas as $siswa)
                        @php
                            $record = $absensi->get($siswa->nis);
                            $status = $record ? $record->status : 'Alpa';
                            $keterangan = $record ? $record->keterangan : '-';
                            $foto_bukti = $record ? $record->foto_bukti : null;
                        @endphp
                        <tr>
                            <td class="px-4 fw-bold">
                                {{ $siswa->nama_siswa }}<br>
                                <small class="text-muted fw-normal">{{ $siswa->nis }}</small>
                            </td>
                            <td class="text-center">
                                @if($status == 'Hadir')
                                    <span class="badge bg-success rounded-pill px-3">Hadir</span>
                                @elseif($status == 'Sakit')
                                    <span class="badge bg-info rounded-pill px-3">Sakit</span>
                                @elseif($status == 'Izin')
                                    <span class="badge bg-warning text-dark rounded-pill px-3">Izin</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3">Alpa</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($foto_bukti)
                                    <img src="{{ asset('storage/uploads/absensi/' . $foto_bukti) }}" 
                                         class="rounded shadow-sm" 
                                         style="width: 50px; height: 50px; object-fit: cover; cursor: pointer; transform: scaleX(-1);"
                                         data-bs-toggle="modal" data-bs-target="#imgModal{{ $siswa->nis }}">
                                    
                                    <div class="modal fade" id="imgModal{{ $siswa->nis }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 bg-transparent text-center">
                                                <img src="{{ asset('storage/uploads/absensi/' . $foto_bukti) }}" 
                                                     class="img-fluid rounded-4 shadow-lg" style="transform: scaleX(-1);">
                                                <button type="button" class="btn btn-light mt-3 rounded-pill mx-auto px-4" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted small">Tanpa Foto</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <small class="text-muted">{{ $keterangan }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="fas fa-info-circle fa-2x text-muted mb-3"></i><br>
                                <span class="text-muted">Belum ada data siswa di kelas ini.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .navbar-floating, .btn-outline-dark, .breadcrumb, footer { display: none !important; }
        body { margin: 0; padding: 0; margin-top: 0 !important; }
        .container { max-width: 100% !important; width: 100% !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>
@endsection