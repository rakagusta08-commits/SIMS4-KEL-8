@extends('layouts.master')

@section('content')
<div class="container py-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('absensi.index') }}">Absensi</a></li>
            <li class="breadcrumb-item active">{{ $kelas->nama_kelas }}</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm" style="border-radius: 25px; overflow: hidden;">
        <div class="card-header bg-dark p-4 border-0">
            <div class="row align-items-center">
                <div class="col-md-6 text-white text-center text-md-start">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-clipboard-list me-2"></i> Input Absensi: {{ $kelas->nama_kelas }}</h4>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <span class="text-white-50"><i class="fas fa-calendar-alt me-1"></i> {{ $tanggal }}</span>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4">
            
            {{-- 🚀 FITUR BARU: BANNER & TOMBOL QR CODE RAKSASA --}}
            <div class="mb-4 p-4 rounded-4 d-flex flex-column flex-md-row justify-content-between align-items-center" style="background: rgba(13, 110, 253, 0.05); border: 2px dashed #0d6efd;">
                <div class="mb-3 mb-md-0 text-center text-md-start">
                    <h5 class="fw-bold text-primary mb-1"><i class="fas fa-qrcode me-2"></i> Mode Absensi Mandiri (QR Code)</h5>
                    <p class="small text-muted mb-0">Tekan tombol di samping untuk menampilkan QR Code Raksasa di layar kelas/proyektor agar siswa bisa scan menggunakan HP mereka.</p>
                </div>
                <div>
                    {{-- Target="_blank" agar QR terbuka di tab baru, sementara guru tetap bisa lihat tabel manual ini --}}
                    <a href="{{ route('absensi.qr.generate', $kelas->id) }}" target="_blank" class="btn btn-primary rounded-pill fw-bold shadow px-4 py-2" style="background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%); border: none;">
                        <i class="fas fa-expand me-2"></i> Tampilkan Layar QR
                    </a>
                </div>
            </div>

            <hr class="mb-4 opacity-25">
            
            {{-- Form Pengiriman Data Manual (Tetap Aman) --}}
            <form action="{{ route('absensi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 px-4" width="150">NIS</th>
                                <th class="py-3">Nama Siswa</th>
                                <th class="py-3 text-center" width="300">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_siswa as $s)
                            @php 
                                // LOGIKA PINTAR: Ambil data absen hari ini untuk siswa ini (jika ada)
                                $absen = isset($absen_hari_ini) ? $absen_hari_ini->get($s->nis) : null;
                                $status_aktif = $absen ? $absen->status : ''; 
                            @endphp
                            <tr>
                                <td class="px-4 fw-bold text-primary">{{ $s->nis }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="fw-bold fs-6">{{ $s->nama_siswa }}</div>
                                            
                                            {{-- FITUR LIHAT SELFIE (Hanya muncul kalau siswa ngirim foto) --}}
                                            @if($absen && $absen->foto_bukti)
                                                <div class="mt-1">
                                                    <span class="text-success shadow-sm px-2 py-1 rounded bg-light border border-success border-opacity-25" style="font-size: 0.75rem; cursor: pointer; transition: 0.2s;" data-bs-toggle="modal" data-bs-target="#modalFoto{{ $s->nis }}" onmouseover="this.classList.add('bg-success', 'text-white')" onmouseout="this.classList.remove('bg-success', 'text-white')">
                                                        <i class="fas fa-camera me-1"></i> Lihat Selfie Absen
                                                    </span>
                                                </div>

                                                {{-- Modal Foto Selfie --}}
                                                <div class="modal fade" id="modalFoto{{ $s->nis }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                                        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                                            <div class="modal-body text-center p-4">
                                                                <h6 class="fw-bold mb-3 text-dark">Bukti Hadir</h6>
                                                                <img src="{{ asset('storage/uploads/absensi/'.$absen->foto_bukti) }}" class="img-fluid rounded-4 mb-3 shadow-sm" alt="Selfie {{ $s->nama_siswa }}">
                                                                <div class="fw-bold text-primary">{{ $s->nama_siswa }}</div>
                                                                <div class="text-muted small mb-3">Status: <span class="badge bg-success">{{ $absen->status }}</span></div>
                                                                <button type="button" class="btn btn-dark btn-sm rounded-pill w-100 fw-bold" data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        {{-- AREA TOMBOL RADIO --}}
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- Hadir (Otomatis nyala kalau status_aktif = Hadir ATAU masih kosong/belum absen) --}}
                                            <input type="radio" class="btn-check" name="status[{{ $s->nis }}]" id="h-{{ $s->nis }}" value="Hadir" 
                                                {{ ($status_aktif == 'Hadir' || $status_aktif == '') ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold" for="h-{{ $s->nis }}">H</label>

                                            {{-- Sakit --}}
                                            <input type="radio" class="btn-check" name="status[{{ $s->nis }}]" id="s-{{ $s->nis }}" value="Sakit"
                                                {{ ($status_aktif == 'Sakit') ? 'checked' : '' }}>
                                            <label class="btn btn-outline-info btn-sm rounded-pill px-3 fw-bold" for="s-{{ $s->nis }}">S</label>

                                            {{-- Izin --}}
                                            <input type="radio" class="btn-check" name="status[{{ $s->nis }}]" id="i-{{ $s->nis }}" value="Izin"
                                                {{ ($status_aktif == 'Izin') ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning btn-sm rounded-pill px-3 fw-bold" for="i-{{ $s->nis }}">I</label>

                                            {{-- Alpa --}}
                                            <input type="radio" class="btn-check" name="status[{{ $s->nis }}]" id="a-{{ $s->nis }}" value="Alpa"
                                                {{ ($status_aktif == 'Alpa') ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold" for="a-{{ $s->nis }}">A</label>
                                        </div>

                                        {{-- TAMBAHAN: Lencana Info jika siswa sudah absen mandiri via QR --}}
                                        @if($status_aktif != '')
                                            <div class="mt-2">
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" style="font-size: 0.65rem;">
                                                    <i class="fas fa-check-circle me-1"></i> Telah disinkronisasi
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Keterangan & Tombol Simpan --}}
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 px-2">
                    <div class="small text-muted fw-bold mb-3 mb-md-0">
                        <span class="text-success me-2">H = Hadir</span>
                        <span class="text-info me-2">S = Sakit</span>
                        <span class="text-warning me-2">I = Izin</span>
                        <span class="text-danger">A = Alpa</span>
                    </div>
                    <div>
                        <a href="{{ route('absensi.index') }}" class="btn btn-light px-4 py-2 rounded-pill me-2 fw-bold">Batal</a>
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill fw-bold shadow-sm">
                            Simpan Absensi Manual <i class="fas fa-save ms-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Pewarnaan Radio Button saat dipilih */
    .btn-check:checked + .btn-outline-success { background-color: #198754; color: white; border-color: #198754; box-shadow: 0 4px 10px rgba(25,135,84,0.3); }
    .btn-check:checked + .btn-outline-info { background-color: #0dcaf0; color: white; border-color: #0dcaf0; box-shadow: 0 4px 10px rgba(13,202,240,0.3); }
    .btn-check:checked + .btn-outline-warning { background-color: #ffc107; color: white; border-color: #ffc107; box-shadow: 0 4px 10px rgba(255,193,7,0.3); }
    .btn-check:checked + .btn-outline-danger { background-color: #dc3545; color: white; border-color: #dc3545; box-shadow: 0 4px 10px rgba(220,53,69,0.3); }
    
    /* Hover effect pada baris tabel */
    .table-hover tbody tr:hover {
        background-color: rgba(37, 99, 235, 0.03);
        transition: background-color 0.2s ease;
    }
</style>
@endsection