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
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="main-split-container">
        <!-- SISI KIRI (Hero Section) -->
        <div class="hero-section">
            <div class="hero-content">
                <!-- Ruang Placeholder Logo -->
                <div class="logo-placeholder">
                    <span>LOGO HERE</span>
                </div>

                <h1>Pemberdayaan Masyarakat<br>Jakarta Barat</h1>
                <p>
                    Portal terpadu untuk pelatihan, sertifikasi, dan pengembangan<br>
                    kapabilitas warga Kota Administrasi Jakarta Barat menuju<br>
                    kemandirian ekonomi.
                </p>
                <div class="hero-badges">
                    <div class="badge">Aman & Terverifikasi</div>
                    <div class="badge">Pelatihan Berkualitas</div>
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
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="login-form">
                    @csrf

                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <div class="input-icon-wrapper">
                            <span class="icon-mail">&#128231;</span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email terdaftar" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="label-row">
                            <label for="password">Kata Sandi</label>
                            <a href="#" class="forgot-password">Lupa Password?</a>
                        </div>
                        <div class="input-icon-wrapper">
                            <span class="icon-lock">&#128274;</span>
                            <input type="password" id="password" name="password" placeholder="Masukkan kata sandi Anda" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">
                        Masuk &nbsp; &#10140;
                    </button>
                </form>

                <footer class="form-footer">
                    <p>&copy; Pemkot Administrasi Jakarta Barat &copy; 2024</p>
                    <p>Sistem Informasi Terpadu</p>
                </footer>
            </div>
        </div>
    </div>

</body>
</html>