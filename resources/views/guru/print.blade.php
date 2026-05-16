<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Siswa - SMKN 4 Bandung</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 30px; color: #333; }
        
        /* CSS SAKTI: Memaksa warna muncul saat diprint */
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print { display: none; }
            body { padding: 0; }
        }

        .header { 
            text-align: center; 
            margin-bottom: 20px; 
            border-bottom: 5px double #000; 
            padding-bottom: 10px; 
        }
        .header h2 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .header h3 { margin: 5px 0; font-size: 18px; }
        .header p { margin: 0; font-size: 12px; font-style: italic; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #444; }
        
        /* Header Tabel Berwarna Biru */
        th { 
            background-color: #0d6efd !important; 
            color: white !important; 
            padding: 12px; 
            text-align: center;
            text-transform: uppercase;
            font-size: 13px;
        }
        
        td { padding: 10px; font-size: 13px; }
        .text-center { text-align: center; }
        
        /* Baris Selang-seling */
        tbody tr:nth-child(even) { background-color: #f9f9f9 !important; }

        .badge-l { color: #0d6efd; font-weight: bold; }
        .badge-p { color: #dc3545; font-weight: bold; }

        .footer { margin-top: 50px; text-align: right; padding-right: 50px; }
        .footer p { margin: 0; }
        .signature-space { height: 80px; }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>Laporan Data Siswa</h2>
        <h3>SMKN 4 KOTA BANDUNG</h3>
        <p>Jl. Babakan Tarogong No.175, Pasir Koja, Kec. Bojongloa Kaler, Kota Bandung</p>
    </div>

    <p style="font-size: 12px;">Dibuat pada: {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIS</th>
                <th>Nama Lengkap</th>
                <th width="15%">Kelas</th>
                <th width="10%">JK</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data_siswa as $s)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center"><b>{{ $s->nis }}</b></td>
                <td>{{ $s->nama_siswa }}</td>
                <td class="text-center">{{ $s->kelas }}</td>
                <td class="text-center">
                    @if(strtoupper($s->jenkel) == 'L')
                        <span class="badge-l">L</span>
                    @else
                        <span class="badge-p">P</span>
                    @endif
                </td>
                <td>{{ $s->alamat }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data siswa.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Bandung, {{ date('d F Y') }}</p>
        <p>Petugas Administrator,</p>
        <div class="signature-space"></div>
        <p><b>{{ Auth::guard('guru')->user()->nama_guru }}</b></p>
        <p>NIP. ————————</p>
    </div>

    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <hr>
        <button onclick="window.location.href='{{ route('siswa.index') }}'" style="padding: 10px 20px; cursor: pointer; background: #6c757d; color: white; border: none; border-radius: 5px;">
             <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </button>
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background: #0d6efd; color: white; border: none; border-radius: 5px; margin-left: 10px;">
             <i class="fas fa-print"></i> Cetak Ulang
        </button>
    </div>

</body>
</html>