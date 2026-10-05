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
            --neutral:      #f1f5f9;
            --surface:      #ffffff;
            --brand:        #12395B;
            --brand-hover:  #0d2a43;
            --brand-deep:   #0a1f33;
            --brand-soft:   #eef4f9;
            --text:         #0f172a;
            --text-mute:    #64748b;
            --line:         #e5e7eb;
            --line-soft:    #f1f5f9;

            --danger:       #dc2626;
            --danger-soft:  #fee2e2;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body { height: 100%; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 15px;
            line-height: 1.5;
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            background-color: var(--brand-deep);

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* ================= BACKGROUND LAYERS ================= */
        /* Layer 1: Foto gedung (fixed) */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url('{{ asset("images/bg-jakarta.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -2;
            pointer-events: none;
        }

        /* Layer 2: Overlay biru navy (aksen seperti gambar ketiga) */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background:
                linear-gradient(
                    135deg,
                    rgba(18, 57, 91, 0.88) 0%,
                    rgba(10, 31, 51, 0.94) 100%
                );
            z-index: -1;
            pointer-events: none;
        }

        /* ================= CARD ================= */
        .login-card {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 400px 1fr;
            width: 100%;
            max-width: 960px;
            min-height: 580px;
            background: var(--surface);
            border-radius: 16px;
            overflow: hidden;
            box-shadow:
                0 24px 60px -16px rgba(0, 0, 0, 0.55),
                0 0 0 1px rgba(255, 255, 255, 0.1);
        }

        /* ================= BRAND (KIRI) ================= */
        .login-card__brand {
            background: linear-gradient(160deg, #16456e 0%, var(--brand) 55%, #0f3251 100%);
            color: #fff;
            padding: 2.5rem 2.25rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        /* Tekstur garis diagonal halus */
        .login-card__brand::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 24px 24px;
            mask-image: linear-gradient(180deg, transparent, #000 40%, transparent);
            pointer-events: none;
        }
        .login-card__brand::after {
            content: '';
            position: absolute;
            top: 12%;
            right: 0;
            width: 1px;
            height: 76%;
            background: rgba(255, 255, 255, 0.08);
            pointer-events: none;
        }

        .brand-head {
            display: flex;
            align-items: center;
            gap: .85rem;
            position: relative;
            z-index: 1;
        }
        .brand-logo {
            width: 42px;
            height: 42px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 6px;
            flex-shrink: 0;
        }
        .brand-name {
            font-size: .92rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }
        .brand-role {
            font-size: .72rem;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.2;
        }

        .brand-body {
            margin: 2rem 0;
            position: relative;
            z-index: 1;
        }
        .brand-title {
            font-size: 1.65rem;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -.02em;
            color: #fff;
            margin-bottom: .85rem;
        }
        .brand-desc {
            font-size: .85rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 1.75rem;
        }

        .brand-points {
            display: flex;
            flex-direction: column;
            gap: .65rem;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }
        .brand-point {
            display: flex;
            align-items: center;
            gap: .6rem;
            font-size: .78rem;
            color: rgba(255, 255, 255, 0.85);
        }
        .brand-point svg {
            flex-shrink: 0;
            opacity: .9;
            width: 15px;
            height: 15px;
        }

        .brand-foot {
            font-size: .7rem;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: .02em;
            position: relative;
            z-index: 1;
        }

        /* ================= FORM (KANAN) ================= */
        .login-card__form {
            padding: 3rem 3.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--surface);
        }
        .form-inner {
            width: 100%;
            max-width: 380px;
        }

        .form-header {
            margin-bottom: 2rem;
        }
        .form-header h1 {
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--brand);
            letter-spacing: -.02em;
            margin-bottom: .5rem;
            line-height: 1.15;
        }
        .form-header p {
            font-size: .85rem;
            color: var(--text-mute);
            line-height: 1.5;
        }

        /* ================= ALERT ================= */
        .form-alert {
            display: flex;
            align-items: flex-start;
            gap: .6rem;
            padding: .85rem 1rem;
            background: var(--danger-soft);
            border: 1px solid #fecaca;
            border-radius: 8px;
            color: #991b1b;
            font-size: .82rem;
            font-weight: 500;
            margin-bottom: 1.35rem;
            line-height: 1.45;
        }
        .form-alert svg { flex-shrink: 0; margin-top: 1px; }

        /* ================= FORM ================= */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: .45rem;
        }
        .form-label-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: .5rem;
        }
        .form-label-row label,
        .form-group > label {
            font-size: .82rem;
            font-weight: 600;
            color: var(--text);
        }

        .forgot-link {
            font-size: .78rem;
            font-weight: 500;
            color: var(--brand);
            text-decoration: none;
            transition: color .15s ease;
        }
        .forgot-link:hover {
            color: var(--brand-hover);
            text-decoration: underline;
        }
        .forgot-link:focus-visible {
            outline: 2px solid var(--brand);
            outline-offset: 2px;
            border-radius: 3px;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
            position: absolute;
            left: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-mute);
            pointer-events: none;
            transition: color .15s ease;
        }
        .input-icon svg { width: 17px; height: 17px; }
        .input-wrap:focus-within .input-icon { color: var(--brand); }

        .input-wrap input {
            width: 100%;
            padding: .8rem 1rem .8rem 2.6rem;
            font-family: inherit;
            font-size: .88rem;
            color: var(--text);
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 8px;
            outline: none;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .input-wrap input::placeholder { color: #94a3b8; }
        .input-wrap input:hover:not(:focus) { border-color: #cbd5e1; }
        .input-wrap input:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(18, 57, 91, 0.1);
        }
        .input-wrap.has-suffix input { padding-right: 2.65rem; }

        .toggle-password {
            position: absolute;
            right: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            background: transparent;
            border: none;
            border-radius: 6px;
            color: var(--text-mute);
            cursor: pointer;
            transition: background .15s ease, color .15s ease;
        }
        .toggle-password:hover { background: var(--neutral); color: var(--text); }
        .toggle-password:focus-visible { outline: 2px solid var(--brand); outline-offset: 1px; }

        /* ================= BUTTON ================= */
        .btn-login {
            width: 100%;
            margin-top: .35rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .85rem 1.5rem;
            background: var(--brand);
            color: #fff;
            font-family: inherit;
            font-size: .9rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background .15s ease;
        }
        .btn-login:hover { background: var(--brand-hover); }
        .btn-login:focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }
        .btn-login:disabled { opacity: .75; cursor: wait; }
        .btn-login .spinner {
            width: 15px;
            height: 15px;
            border: 2px solid rgba(255, 255, 255, 0.35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ================= FOOTER (dalam card) ================= */
        .form-foot {
            margin-top: 2rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--line-soft);
            font-size: .72rem;
            color: var(--text-mute);
            line-height: 1.6;
            text-align: center;
        }

        /* ================= FOOTER (luar card) ================= */
        .page-foot {
            position: relative;
            z-index: 1;
            margin-top: 1.25rem;
            font-size: .72rem;
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            letter-spacing: .01em;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 820px) {
            body {
                padding: 0;
                align-items: stretch;
                justify-content: flex-start;
            }
            .login-card {
                grid-template-columns: 1fr;
                max-width: 100%;
                min-height: 100vh;
                border-radius: 0;
                box-shadow: none;
            }
            .login-card__brand {
                padding: 1.75rem 1.5rem;
                min-height: auto;
            }
            .login-card__brand::before,
            .login-card__brand::after { display: none; }
            .brand-body { margin: 1rem 0 0; }
            .brand-title {
                font-size: 1.35rem;
                margin-bottom: .5rem;
            }
            .brand-desc {
                font-size: .8rem;
                margin-bottom: 0;
            }
            .brand-points {
                flex-direction: row;
                flex-wrap: wrap;
                gap: .5rem 1.25rem;
                padding-top: .9rem;
                margin-top: 1rem;
            }
            .brand-point { font-size: .74rem; }
            .brand-foot { display: none; }

            .login-card__form {
                padding: 2rem 1.5rem 2.5rem;
                align-items: flex-start;
                flex: 1;
            }
            .form-inner { max-width: 100%; }
            .form-header { margin-bottom: 1.5rem; }
            .form-header h1 { font-size: 1.4rem; }

            .page-foot { display: none; }
        }

        @media (max-width: 480px) {
            .login-card__brand { padding: 1.5rem 1.25rem; }
            .brand-logo { width: 36px; height: 36px; padding: 5px; }
            .brand-title { font-size: 1.2rem; }
            .login-card__form { padding: 1.75rem 1.25rem 2rem; }
        }
    </style>
</head>
<body>

    <div class="login-card">

        <!-- ============ BRAND ============ -->
        <aside class="login-card__brand">
            <div class="brand-head">
                <img src="{{ asset('images/Logo-Jakarta.png') }}" alt="Logo Jakarta Barat" class="brand-logo">
                <div>
                    <div class="brand-name">Kota Jakarta Barat</div>
                    <div class="brand-role">Kota Administrasi</div>
                </div>
            </div>

            <div class="brand-body">
                <h2 class="brand-title">Pemberdayaan Masyarakat Jakarta Barat</h2>
                <p class="brand-desc">
                    Portal terpadu untuk pelatihan, sertifikasi, dan pengembangan kapabilitas warga
                    Kota Administrasi Jakarta Barat menuju kemandirian ekonomi.
                </p>

                <div class="brand-points">
                    <div class="brand-point">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Aman &amp; Terverifikasi</span>
                    </div>
                    <div class="brand-point">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                        <span>Pelatihan Berkualitas</span>
                    </div>
                </div>
            </div>

            <div class="brand-foot">
                Sistem Informasi Terpadu
            </div>
        </aside>

        <!-- ============ FORM ============ -->
        <main class="login-card__form">
            <div class="form-inner">

                <div class="form-header">
                    <h1>Masuk</h1>
                    <p>Silakan masukkan kredensial Anda untuk melanjutkan ke dashboard.</p>
                </div>

                @if ($errors->any())
                    <div class="form-alert" role="alert">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="login-form" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                autocomplete="username"
                                inputmode="email"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-row">
                            <label for="password">Kata Sandi</label>
                            <a href="#" class="forgot-link">Lupa Password?</a>
                        </div>
                        <div class="input-wrap has-suffix">
                            <span class="input-icon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan kata sandi"
                                autocomplete="current-password"
                                required
                            >
                            <button type="button"
                                    class="toggle-password"
                                    aria-label="Tampilkan kata sandi"
                                    aria-controls="password"
                                    data-toggle-password>
                                <svg class="icon-eye" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg class="icon-eye-off" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-login" data-submit-btn>
                        <span data-btn-label>Masuk</span>
                        <svg data-btn-icon width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>

                <div class="form-foot">
                    <div>Sistem Informasi Terpadu</div>
                    <div>&copy; {{ date('Y') }} Pemkot Administrasi Jakarta Barat</div>
                </div>

            </div>
        </main>

    </div>

    <div class="page-foot">
        &copy; {{ date('Y') }} Pemerintah Kota Administrasi Jakarta Barat
    </div>

    <script>
        document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = document.getElementById(btn.getAttribute('aria-controls'));
                if (!input) return;

                var isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                btn.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');

                var eye    = btn.querySelector('.icon-eye');
                var eyeOff = btn.querySelector('.icon-eye-off');
                if (eye && eyeOff) {
                    eye.style.display    = isPassword ? 'none' : '';
                    eyeOff.style.display = isPassword ? '' : 'none';
                }
            });
        });

        var form = document.getElementById('loginForm');
        if (form) {
            form.addEventListener('submit', function () {
                var btn = form.querySelector('[data-submit-btn]');
                if (!btn || btn.disabled) return;

                btn.disabled = true;
                var label = btn.querySelector('[data-btn-label]');
                var icon  = btn.querySelector('[data-btn-icon]');
                if (label) label.textContent = 'Memproses...';
                if (icon)  icon.outerHTML = '<span class="spinner"></span>';
            });
        }
    </script>

</body>
</html>