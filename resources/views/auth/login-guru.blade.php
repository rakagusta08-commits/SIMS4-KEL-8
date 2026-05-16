<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Guru | SMKN 4 Bandung</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        /* ================= ROOT ================= */
        :root {
            /* 🚀 FIX: Tema Guru menggunakan warna Navy/Indigo sebagai dominan */
            --primary: #4f46e5; /* Indigo */
            --primary-dark: #312e81;
            --navy: #0f172a;
        }

        /* ================= BODY ================= */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(-45deg, #eef2ff, #f8fafc, #e0e7ff, #f1f5f9);
            background-size: 400% 400%;
            animation: bgMove 12s ease infinite;
            overflow: hidden;
            padding: 20px;
        }

        @keyframes bgMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* ================= BLOBS ================= */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            opacity: .35;
            z-index: -1;
        }

        .blob1 {
            width: 350px; height: 350px;
            background: var(--primary);
            top: -120px; left: -120px;
        }

        .blob2 {
            width: 400px; height: 400px;
            background: var(--navy);
            bottom: -150px; right: -150px;
        }

        /* ================= CARD ================= */
        .login-card {
            width: 100%;
            max-width: 950px;
            background: rgba(255, 255, 255, .65);
            backdrop-filter: blur(16px);
            border-radius: 28px;
            overflow: hidden;
            display: flex;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(255, 255, 255, .7);
            animation: fadeUp .9s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ================= LEFT SIDE (FOTO) ================= */
        .side-photo {
            flex: 1.1;
            /* 🚀 FIX: Gradien overlay dibuat lebih transparan (.6 dan .7) agar gambar papan tulis di belakang muncul */
            background: linear-gradient(rgba(49, 46, 129, .6), rgba(15, 23, 42, .7)),
                        url('https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=800&q=80');
            background-size: cover;
            background-position: center;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .side-photo i {
            font-size: 4rem;
            margin-bottom: 25px;
            animation: floating 3s ease-in-out infinite;
            color: #a5b4fc; /* Aksen warna ikon */
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* ================= FORM SIDE ================= */
        .side-form {
            flex: 1;
            padding: 60px 50px;
            background: rgba(255, 255, 255, .9);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-text {
            font-weight: 800;
            letter-spacing: -.5px;
            color: var(--navy);
        }

        /* ================= INPUT ================= */
        .form-control {
            border-radius: 14px;
            padding: 14px 18px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            transition: .3s;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, .15);
            transform: scale(1.02);
        }

        /* ================= BUTTON ================= */
        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            padding: 14px;
            border-radius: 14px;
            font-weight: 800;
            letter-spacing: .8px;
            color: white;
            width: 100%;
            transition: .35s;
            position: relative;
            overflow: hidden;
            margin-top: 10px;
        }

        .btn-login::before {
            content: "";
            position: absolute;
            width: 120%; height: 120%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, .3), transparent);
            top: -10%; left: -120%;
            transition: .6s;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(79, 70, 229, .35);
        }

        .btn-login:hover::before { left: 120%; }

        /* ================= ANIMATION ================= */
        .input-anim {
            opacity: 0;
            animation: fadeInUp .6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .delay-1 { animation-delay: .2s; }
        .delay-2 { animation-delay: .4s; }
        .delay-3 { animation-delay: .6s; }

        /* ================= SHOW PASSWORD ICON ================= */
        .password-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            transition: color 0.3s;
        }
        .toggle-password:hover { color: var(--primary); }

        /* ================= BACK BUTTON ================= */
        .btn-back {
            position: absolute;
            top: 25px; left: 25px;
            color: white;
            background: rgba(255,255,255,0.15);
            padding: 8px 15px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            backdrop-filter: blur(5px);
            transition: 0.3s;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .btn-back:hover { background: rgba(255,255,255,0.25); color: white; transform: translateX(-3px); }

        /* ================= MOBILE ================= */
        @media(max-width: 900px) {
            .side-photo { display: none; }
            .side-form { padding: 40px 30px; }
            .login-card { max-width: 450px; }
            .btn-back { color: var(--navy); background: rgba(15,23,42,0.1); border-color: rgba(15,23,42,0.1); }
            .btn-back:hover { background: rgba(15,23,42,0.2); color: var(--navy); }
        }
    </style>
</head>

<body>

    <div class="blob blob1"></div>
    <div class="blob blob2"></div>

    <div class="login-card position-relative">

        <a href="/" class="btn-back">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>

        <div class="side-photo">
            <i class="fas fa-chalkboard-teacher"></i>
            <h2 class="fw-bold mb-2">PORTAL GURU</h2>
            <p class="opacity-75 fs-6 px-3">
                Akses dashboard manajemen akademik dan pengelolaan nilai siswa SMKN 4 Bandung.
            </p>
        </div>

        <div class="side-form">
            <div class="mb-5 text-center text-md-start">
                <h2 class="brand-text mb-1">Login Guru</h2>
                <p class="text-muted small">
                    Masukkan NIP atau Email untuk masuk
                </p>
            </div>

            @if(session('error') || session('loginError') || $errors->any())
                <div class="alert alert-danger border-0 small animate__animated animate__shakeX" style="border-radius:12px; background-color: #fef2f2; color: #991b1b;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') ?? session('loginError') ?? 'NIP/Email atau Password salah.' }}
                </div>
            @endif

            <form action="{{ route('login.guru.post') }}" method="POST">
                @csrf

                <div class="mb-3 input-anim delay-1">
                    <label class="form-label small fw-bold text-secondary">
                        NIP / Email
                    </label>
                    <input type="text" name="email" class="form-control"
                           placeholder="Masukkan NIP atau Email"
                           value="{{ old('email') }}" required autofocus autocomplete="off">
                </div>

                <div class="mb-4 input-anim delay-2">
                    <label class="form-label small fw-bold text-secondary">
                        Password
                    </label>
                    <div class="password-container">
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                        <i class="fas fa-eye toggle-password" id="togglePassword" onclick="showHidePassword()"></i>
                    </div>
                </div>

                <div class="input-anim delay-3">
                    <button type="submit" class="btn-login">
                        Masuk
                        <i class="fas fa-arrow-right ms-2"></i>
                    </button>

                    <div class="text-center mt-4">
                        <p class="small text-muted">
                            Bukan Guru?
                            <a href="{{ route('login.siswa') }}" class="fw-bold text-decoration-none" style="color: var(--primary); transition: 0.2s;">
                                Masuk sebagai Siswa
                            </a>
                        </p>
                    </div>
                </div>

            </form>
        </div>

    </div>

    <script>
        function showHidePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePassword');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>