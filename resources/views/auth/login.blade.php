<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Pemberdayaan Masyarakat Jakarta Barat</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #12395B;
            --primary-hover: #0d2a43;
            --primary-light: #ebf3fa;
            --primary-border: #b9d3eb;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --bg-body: #f8fafc;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
        }

        .main-split-container {
            display: flex;
            width: 100vw;
            min-height: 100vh;
        }

        /* SISI KIRI - HERO SECTION (#12395B PALETTE) */
        .hero-section {
            flex: 1.1;
            background: linear-gradient(135deg, #12395B 0%, #0d2a43 100%);
            color: #ffffff;
            padding: 3rem 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Decorative Background Pattern */
        .hero-section::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-content {
            max-width: 540px;
            position: relative;
            z-index: 10;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .logo-img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .logo-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.01em;
        }

        .logo-subtitle {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .hero-section h1 {
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            font-weight: 700;
            line-height: 1.25;
            margin-bottom: 1.25rem;
            color: #ffffff;
            letter-spacing: -0.02em;
        }

        .hero-section p {
            font-size: 1rem;
            line-height: 1.6;
            color: #cbd5e1;
            margin-bottom: 2.25rem;
        }

        .hero-badges {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .badge {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.825rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* SISI KANAN - FORM SECTION */
        .form-section {
            flex: 1;
            background: #ffffff;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .form-content-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            margin-bottom: 2rem;
        }

        .login-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .login-header p {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* ALERT ERROR */
        .login-alert {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 0.85rem 1rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* FORM ELEMENTS */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .form-group label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .forgot-password {
            font-size: 0.8rem;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .forgot-password:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        .input-icon-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-wrapper span {
            position: absolute;
            left: 1rem;
            color: #94a3b8;
            font-size: 1rem;
            pointer-events: none;
        }

        .input-icon-wrapper input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 0.9rem;
            font-family: inherit;
            color: var(--text-main);
            background-color: #ffffff;
            transition: all 0.2s ease;
            outline: none;
        }

        .input-icon-wrapper input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(18, 57, 91, 0.12);
        }

        .input-icon-wrapper input::placeholder {
            color: #94a3b8;
        }

        /* TOMBOL MASUK */
        .btn-login {
            width: 100%;
            background-color: var(--primary);
            color: #ffffff;
            border: none;
            padding: 0.85rem 1.25rem;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(18, 57, 91, 0.2);
        }

        .btn-login:hover {
            background-color: var(--primary-hover);
            box-shadow: 0 6px 16px rgba(18, 57, 91, 0.3);
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* FOOTER */
        .form-footer {
            margin-top: 2.5rem;
            text-align: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 1.5rem;
        }

        .form-footer p {
            font-size: 0.78rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 900px) {
            .main-split-container {
                flex-direction: column;
            }

            .hero-section {
                padding: 2.5rem 1.5rem;
                flex: none;
            }

            .form-section {
                padding: 2.5rem 1.5rem;
                flex: 1;
            }
        }
    </style>
</head>
<body>

    <div class="main-split-container">
        <!-- SISI KIRI (Hero Section) -->
        <div class="hero-section">
            <div class="hero-content">
                <!-- Logo Pemkot Jakbar -->
                <div class="logo-container">
                    <img src="{{ asset('images/Logo-Jakarta.png') }}" alt="Logo Jakbar" class="logo-img">
                    <div>
                        <div class="logo-title">Kota Jakarta Barat</div>
                        <div class="logo-subtitle">Kota Administrasi</div>
                    </div>
                </div>

                <h1>Pemberdayaan Masyarakat<br>Jakarta Barat</h1>
                <p>
                    Portal terpadu untuk pelatihan, sertifikasi, dan pengembangan kapabilitas warga Kota Administrasi Jakarta Barat menuju kemandirian ekonomi.
                </p>

                <div class="hero-badges">
                    <div class="badge">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Aman & Terverifikasi
                    </div>
                    <div class="badge">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        Pelatihan Berkualitas
                    </div>
                </div>
            </div>
        </div>

        <!-- SISI KANAN (Form Section) -->
        <div class="form-section">
            <div class="form-content-wrapper">
                <div class="login-header">
                    <h2>Masuk</h2>
                    <p>Silakan masukkan kredensial Anda untuk melanjutkan ke dashboard.</p>
                </div>

                @if ($errors->any())
                    <div class="login-alert">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="login-form">
                    @csrf

                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <div class="input-icon-wrapper">
                            <span class="icon-mail">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email terdaftar" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="label-row">
                            <label for="password">Kata Sandi</label>
                            <a href="#" class="forgot-password">Lupa Password?</a>
                        </div>
                        <div class="input-icon-wrapper">
                            <span class="icon-lock">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <input type="password" id="password" name="password" placeholder="Masukkan kata sandi Anda" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">
                        <span>Masuk</span>
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </form>

                <footer class="form-footer">
                    <p>&copy; {{ date('Y') }} Pemkot Administrasi Jakarta Barat</p>
                    <p>Sistem Informasi Terpadu</p>
                </footer>
            </div>
        </div>
    </div>

</body>
</html>