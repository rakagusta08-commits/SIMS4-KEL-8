<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Berhasil - SIM SEKOLAH</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            background: #f4f7fe; 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            font-family: 'Inter', 'Segoe UI', sans-serif; 
        }
        .card-success { 
            border: none; 
            border-radius: 28px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            background: #ffffff;
        }
        .check-icon {
            width: 80px;
            height: 80px;
            background: #d1fae5;
            color: #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
        }
        .info-box {
            background: #f8fafc;
            border-radius: 20px;
            padding: 20px;
            text-align: left;
        }
        .label-text {
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
        }
        .label-text i { margin-right: 8px; width: 16px; }
        .value-text {
            color: #1e293b;
            font-weight: 700;
            font-size: 1.05rem;
            word-break: break-all; /* Mencegah NIS kepotong */
        }
        .status-badge {
            background: #10b981;
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            font-weight: 600;
            margin-top: 15px;
        }
        .btn-back {
            background: #ffffff;
            color: #64748b;
            border: 2px solid #e2e8f0;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }
        .btn-back:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #cbd5e1;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center text-center">
        <div class="col-md-5 col-11">
            <div class="card card-success p-4">
                <div class="card-body">
                    <div class="check-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    
                    <h3 class="fw-bold text-success mb-1">Absen Berhasil!</h3>
                    <p class="text-muted small mb-4">Anda tercatat HADIR hari ini</p>

                    <div class="info-box mb-3">
    <div class="row g-3">
        <div class="col-12 border-bottom pb-2 mb-2">
            <div class="label-text"><i class="fas fa-user"></i> Nama</div>
            <div class="value-text text-uppercase">{{ $siswa->nama_siswa ?? $siswa->nama }}</div>
        </div>
        <div class="col-6">
            <div class="label-text"><i class="fas fa-id-card"></i> NIS</div>
            <div class="value-text">{{ $siswa->nis }}</div>
        </div>
        <div class="col-6">
            <div class="label-text"><i class="fas fa-door-open"></i> Kelas</div>
            <div class="value-text">{{ $siswa->kelas->nama ?? $siswa->kelas }}</div>
        </div>
        <div class="col-12 border-top pt-2 mt-2">
            <div class="label-text"><i class="fas fa-clock"></i> Waktu Absen</div>
            <div class="value-text">{{ now()->translatedFormat('l, d F Y - H:i') }} WIB</div>
        </div>
    </div>
</div>
                            <div class="col-12 border-top pt-2 mt-2">
                                <div class="label-text"><i class="fas fa-clock"></i> Waktu</div>
                                <div class="value-text">{{ now()->translatedFormat('l, d F Y - H:i') }} WIB</div>
                            </div>
                        </div>
                    </div>

                    <div class="status-badge">
                        <i class="fas fa-user-check me-2"></i> Status: HADIR
                    </div>

                    <hr class="my-4" style="opacity: 0.1;">

                    <div class="d-grid gap-2">
                        <a href="{{ route('siswa.dashboard') }}" class="btn-back">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                        </a>
                    </div>

                    <p class="text-muted mt-4 mb-0" style="font-size: 0.75rem;">
                        <i class="fas fa-info-circle me-1"></i> Halaman ini dapat ditutup. Selamat beraktivitas! 👋
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>