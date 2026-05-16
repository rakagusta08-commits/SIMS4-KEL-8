<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM Sekolah | Premium Edition</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ==========================================
           1. ROOT & BASE STYLES
        ========================================== */
        :root {
            --blue-primary: #6366f1;
            --blue-dark: #0f172a;
            --blue-glow: rgba(37, 99, 235, 0.4);
            --dark-glow: rgba(15, 23, 42, 0.4);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            min-height: 100vh;
            background-color: #f1f5f9;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        /* ==========================================
           2. ANIMATED BACKGROUND BLOBS (AURA EFEK)
        ========================================== */
        .bg-blobs {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            overflow: hidden;
            z-index: -1;
        }

        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.6;
            animation: float 10s infinite ease-in-out alternate;
        }

        .blob-1 {
            width: 400px; height: 400px;
            background: linear-gradient(135deg, #3b82f6, #93c5fd);
            top: -10%; left: -10%;
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        }

        .blob-2 {
            width: 500px; height: 500px;
            background: linear-gradient(135deg, #60a5fa, #c4b5fd);
            bottom: -20%; right: -10%;
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            animation-delay: -5s;
            animation-duration: 15s;
        }

        .blob-3 {
            width: 300px; height: 300px;
            background: linear-gradient(135deg, #cbd5e1, #e2e8f0);
            top: 40%; left: 40%;
            border-radius: 50%;
            animation-delay: -2s;
            animation-duration: 12s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg) scale(1); }
            50% { transform: translate(50px, 30px) rotate(10deg) scale(1.05); }
            100% { transform: translate(-30px, 50px) rotate(-10deg) scale(0.95); }
        }

        /* ==========================================
           3. MAIN LAYOUT & TEXT ANIMATION
        ========================================== */
        .main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 1rem;
            z-index: 10;
        }

        .animated-gradient-text {
            background: linear-gradient(to right, #6366f1, #8b5cf6, #6366f1);
            background-size: 200% auto;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
            animation: shine 4s linear infinite;
            font-weight: 900;
            letter-spacing: -1.5px;
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }

        @keyframes shine {
            to { background-position: 200% center; }
        }

        @media (max-width: 768px) {
            .animated-gradient-text { font-size: 2.2rem; }
            .header-icon { width: 80px; height: 80px; font-size: 2.5rem; margin-bottom: 0.5rem; }
            .portal-card { padding: 2rem 1.5rem; }
            .icon-wrapper { width: 70px; height: 70px; font-size: 2rem; margin-bottom: 1.5rem; }
            .card-title { font-size: 1.4rem; }
            .card-desc { font-size: 0.9rem; margin-bottom: 1.5rem; }
        }

        /* Ikon Pengganti Logo */
        .header-icon {
            font-size: 3.5rem;
            color: var(--blue-primary);
            margin-bottom: 1rem;
            background: white;
            width: 100px; height: 100px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.15);
            transform: rotate(-5deg);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .header-icon:hover {
            transform: rotate(0deg) scale(1.1);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.25);
        }

        /* ==========================================
           4. GLASSMORPHISM PORTAL CARDS
        ========================================== */
        .portal-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 30px;
            padding: 3rem 2.5rem;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
            transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        /* Glow effect on hover */
        .portal-card::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            border-radius: 30px;
            box-shadow: 0 0 0 0 transparent;
            transition: box-shadow 0.5s ease;
            z-index: -1;
        }

        .portal-card.card-guru:hover {
            transform: translateY(-15px);
            border-color: rgba(37, 99, 235, 0.3);
        }
        .portal-card.card-guru:hover::after {
            box-shadow: 0 25px 50px var(--blue-glow);
        }

        .portal-card.card-siswa:hover {
            transform: translateY(-15px);
            border-color: rgba(15, 23, 42, 0.3);
        }
        .portal-card.card-siswa:hover::after {
            box-shadow: 0 25px 50px var(--dark-glow);
        }

        .icon-wrapper {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            background: var(--icon-bg);
            color: var(--card-color);
            transition: all 0.5s ease;
            position: relative;
        }

        /* Gelombang di belakang ikon */
        .icon-wrapper::before {
            content: '';
            position: absolute;
            top: -10px; left: -10px; right: -10px; bottom: -10px;
            border-radius: 50%;
            background: var(--icon-bg);
            opacity: 0.5;
            z-index: -1;
            transition: all 0.5s ease;
        }

        .portal-card:hover .icon-wrapper {
            transform: scale(1.1);
        }
        .portal-card:hover .icon-wrapper::before {
            transform: scale(1.3);
            opacity: 0;
        }

        .card-title {
            font-weight: 800;
            font-size: 1.6rem;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .card-desc {
            font-size: 1rem;
            color: #64748b;
            margin-bottom: 2.5rem;
            line-height: 1.7;
        }

        /* ==========================================
           5. BUTTONS DENGAN EFEK CAHAYA (SWEEP)
        ========================================== */
        .btn-portal {
            font-weight: 800;
            padding: 1.2rem 1.5rem;
            border-radius: 18px;
            width: 100%;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
            border: none;
            z-index: 1;
        }

        .btn-portal::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 50%; height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-25deg);
            z-index: -1;
            transition: all 0.7s ease;
        }

        .btn-portal:hover::before {
            left: 200%;
        }

        .btn-portal:hover {
            transform: translateY(-3px);
        }

        .card-guru { --card-color: var(--blue-primary); --icon-bg: #eff6ff; }
        .card-siswa { --card-color: var(--blue-dark); --icon-bg: #e2e8f0; }

        .btn-primary { background: var(--blue-primary); box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2); }
        .btn-dark { background: var(--blue-dark); box-shadow: 0 10px 20px rgba(15, 23, 42, 0.2); }

        /* ==========================================
           6. ENTRANCE ANIMATIONS (STAGGERED)
        ========================================== */
        .reveal-up {
            opacity: 0;
            transform: translateY(50px);
            animation: revealUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.3s; }
        .delay-3 { animation-delay: 0.5s; }
        .delay-4 { animation-delay: 0.7s; }

        @keyframes revealUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .footer {
            text-align: center;
            padding: 2rem;
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 600;
            position: relative;
            z-index: 10;
        }
    </style>
</head>
<body>

    <div class="bg-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <div class="main-wrapper">
        <div class="container">
            
            <div class="row justify-content-center text-center mb-5">
                <div class="col-12 col-md-8 d-flex flex-column align-items-center">
                    
                    <div class="header-icon reveal-up delay-1">
                        <i class="fas fa-layer-group"></i>
                    </div>
                         
                    <h1 class="animated-gradient-text reveal-up delay-2">
                        SIM SEKOLAH
                    </h1>
                    <p class="text-muted reveal-up delay-3" style="font-weight: 500; font-size: 1.1rem; max-width: 400px;">
                        Platform Sistem Informasi Manajemen Akademik Terpadu
                    </p>
                </div>
            </div>

            <div class="row justify-content-center g-4">
                
                <div class="col-12 col-md-5 col-lg-4 reveal-up delay-3">
                    <div class="portal-card card-guru">
                        <div>
                            <div class="icon-wrapper">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h2 class="card-title">Portal Guru</h2>
                            <p class="card-desc">
                                Akses dashboard pengajar. Kelola absensi harian, jadwal kelas, dan evaluasi tugas siswa dengan mudah.
                            </p>
                        </div>
                        <a href="/login/guru" class="btn btn-primary btn-portal text-white">
                            Masuk Guru <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-5 col-lg-4 reveal-up delay-4">
                    <div class="portal-card card-siswa">
                        <div>
                            <div class="icon-wrapper">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h2 class="card-title">Portal Siswa</h2>
                            <p class="card-desc">
                                Akses ruang belajarmu. Pantau jadwal mata pelajaran, rekap absensi, dan kumpulkan tugas tepat waktu.
                            </p>
                        </div>
                        <a href="/login/siswa" class="btn btn-dark btn-portal text-white">
                            Masuk Siswa <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer class="footer reveal-up delay-4">
        &copy; 2026 Sistem Informasi Sekolah - Crafted with <i class="fas fa-heart text-danger mx-1"></i> by <b>KEL 8</b>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>