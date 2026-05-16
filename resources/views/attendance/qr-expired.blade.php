<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Kadaluarsa - Sistem Absensi SMKN 4 Bandung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #8b5cf6;
            --danger: #ef4444;
        }

        body {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container-expired {
            width: 100%;
            max-width: 500px;
            margin: 20px;
        }

        .card-expired {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            border: none;
            text-align: center;
            padding: 60px 30px;
        }

        .icon-expired {
            font-size: 4rem;
            color: var(--danger);
            margin-bottom: 20px;
            animation: slideDown 0.6s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .title-expired {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }

        .message-expired {
            color: #666;
            font-size: 1rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .info-box {
            background: linear-gradient(135deg, #fef3c7, #fef08a);
            border-left: 5px solid #f59e0b;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }

        .info-box h5 {
            color: #92400e;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .info-box ul {
            list-style: none;
            padding: 0;
            margin: 0;
            color: #b45309;
        }

        .info-box li {
            margin: 8px 0;
            padding-left: 25px;
            position: relative;
        }

        .info-box li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #f59e0b;
            font-weight: bold;
        }

        .btn-expired {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            display: inline-block;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-expired:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
            color: white;
        }

        .footer-expired {
            color: #999;
            font-size: 0.85rem;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container-expired animate__animated animate__fadeIn">
        <div class="card-expired">
            <div class="icon-expired">
                <i class="fas fa-exclamation-triangle"></i>
            </div>

            <h2 class="title-expired">QR Code Kadaluarsa</h2>
            <p class="message-expired">
                Maaf, bentuk kode QR ini sudah tidak berlaku. Untuk absensi, silakan minta guru untuk membuat QR Code baru.
            </p>

            <div class="info-box">
                <h5><i class="fas fa-lightbulb me-2"></i>Apa yang harus dilakukan?</h5>
                <ul>
                    <li>Hubungi guru Anda untuk meminta QR Code absensi yang baru</li>
                    <li>Pastikan QR Code masih dalam masa berlaku (30 menit)</li>
                    <li>Coba scan QR Code lagi dari awal</li>
                </ul>
            </div>

            <a href="/" class="btn-expired">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
            </a>

            <div class="footer-expired">
                <i class="fas fa-info-circle me-1"></i>
                Pertanyaan? Hubungi admin sekolah
            </div>
        </div>
    </div>
</body>
</html>
