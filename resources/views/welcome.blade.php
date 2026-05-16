<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM Sekolah | SMKN 4 Bandung</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ================= GLOBAL ================= */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            background: linear-gradient(-45deg, #eef2ff, #f1f5f9, #e2e8f0, #f8fafc);
            background-size: 400% 400%;
            animation: bgGradient 12s ease infinite;
        }

        @keyframes bgGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* ================= FLOATING BLOBS ================= */
        .blob {
            position: absolute; border-radius: 50%;
            filter: blur(80px); opacity: .35; z-index: -1;
            animation: blobMove 18s infinite alternate;
        }

        .blob1 {
            width: 350px; height: 350px; background: #3b82f6;
            top: -100px; left: -100px;
        }

        .blob2 {
            width: 400px; height: 400px; background: #0f172a;
            bottom: -120px; right: -120px; animation-direction: alternate-reverse;
        }

        @keyframes blobMove {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(80px, -60px) scale(1.1); }
        }

        /* ================= MAIN & ANIMATIONS ================= */
        .main-wrapper { flex: 1; display: flex; align-items: center; justify-content: center; padding: 3rem 1rem; }

        .fade-down { animation: fadeDown 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
        .fade-up { animation: fadeUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; transform: translateY(40px); }
        
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.6s; }

        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* ================= TITLE AREA ================= */
        .top-icon {
            font-size: 3rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
            display: inline-block;
        }

        .main-title { font-weight: 900; font-size: 2.5rem; letter-spacing: -1px; color: #0f172a; }

        /* ================= GLASS CARD & VARIABLES ================= */
        /* Kita bikin variabel warna biar GURU dan SISWA beda warna otomatis! */
        .card-guru { --theme-1: #6366f1; --theme-2: #8b5cf6; --theme-glow: rgba(99,102,241,.35); }
        .card-siswa { --theme-1: #0f172a; --theme-2: #334155; --theme-glow: rgba(15,23,42,.35); }

        .portal-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(16px);
            border-radius: 26px;
            padding: 2.6rem 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.04);
            transition: all .4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex; flex-direction: column; justify-content: space-between;
            position: relative; overflow: hidden;
        }

        .portal-card::before {
            content: ""; position: absolute; inset: 0; border-radius: 26px; padding: 2px;
            background: linear-gradient(120deg, var(--theme-1), var(--theme-2), var(--theme-1));
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor; mask-composite: exclude;
            opacity: .2; transition: opacity .4s ease;
        }

        .portal-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
        }
        .portal-card:hover::before { opacity: .6; }

        /* ================= ICON ================= */
        .icon-wrapper {
            width: 90px; height: 90px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.6rem; font-size: 2.3rem;
            background: linear-gradient(135deg, var(--theme-1), var(--theme-2));
            color: white;
            animation: floating 3s ease-in-out infinite;
            box-shadow: 0 10px 20px var(--theme-glow);
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        /* ================= TEXT ================= */
        .card-title { font-weight: 800; font-size: 1.4rem; color: #0f172a; margin-bottom: 1rem; }
        .card-desc { font-size: .95rem; color: #64748b; line-height: 1.6; margin-bottom: 2rem; }

        /* ================= BUTTON ================= */
        .btn-portal {
            display: inline-block; text-decoration: none; font-weight: 700;
            padding: 1rem 1.5rem; border-radius: 14px; width: 100%;
            background: linear-gradient(135deg, var(--theme-1), var(--theme-2));
            border: none; color: white; transition: all .3s ease;
            position: relative; overflow: hidden;
            letter-spacing: 0.5px;
        }

        .btn-portal::before {
            content: ""; position: absolute; width: 120%; height: 120%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, .3), transparent);
            top: -10%; left: -120%; transition: .6s;
        }

        .btn-portal:hover {
            transform: translateY(-3px); box-shadow: 0 12px 24px var(--theme-glow); color: white;
        }
        .btn-portal:hover::before { left: 120%; }

        /* ================= FOOTER ================= */
        .footer { text-align: center; padding: 1.5rem; color: #64748b; font-size: .85rem; font-weight: 600; }

        @media(max-width: 768px) {
            .main-title { font-size: 2.2rem; }
            .portal-card { padding: 2.2rem 1.5rem; }
        }
    </style>
</head>
<body>

    <div class="blob blob1"></div>
    <div class="blob blob2"></div>

    <div class="main-wrapper">
        <div class="container">
            
            <div class="row justify-content-center text-center mb-5 fade-down">
                <div class="col-md-8">
                    <i class="fas fa-graduation-cap top-icon"></i>
                    <h1 class="main-title">SIM SEKOLAH</h1>
                    <p class="text-muted fw-medium" style="font-size: 1.05rem;">
                        Sistem Informasi Manajemen <br class="d-md-none"> SMKN 4 Bandung
                    </p>
                </div>
            </div>

            <div class="row justify-content-center g-4">
                
                <div class="col-12 col-md-5 col-lg-4 fade-up delay-1">
                    <div class="portal-card card-guru">
                        <div>
                            <div class="icon-wrapper">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h2 class="card-title">Portal Guru</h2>
                            <p class="card-desc">
                                Akses pengajar untuk mengelola nilai, presensi, jadwal pelajaran, serta tugas siswa.
                            </p>
                        </div>
                        <a href="/login/guru" class="btn-portal">
                            Masuk Guru <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-5 col-lg-4 fade-up delay-2">
                    <div class="portal-card card-siswa">
                        <div>
                            <div class="icon-wrapper">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h2 class="card-title">Portal Siswa</h2>
                            <p class="card-desc">
                                Siswa dapat melihat jadwal pelajaran, materi pembelajaran, serta mengumpulkan tugas.
                            </p>
                        </div>
                        <a href="/login/siswa" class="btn-portal">
                            Masuk Siswa <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer class="footer fade-up delay-3">
        &copy; 2026 SMKN 4 Bandung <br>
        Developed by <strong>KELOMPOK 8</strong>
    </footer>

</body>
</html>