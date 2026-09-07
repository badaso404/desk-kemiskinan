<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pemberdayaan Masyarakat Jakarta Barat')</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('beranda') }}" class="nav-brand">
                <span class="brand-mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M3 10 12 4l9 6"/><path d="M5 10v9h14v-9"/><path d="M10 19v-5h4v5"/>
                    </svg>
                </span>
                <span class="brand-title">Pemberdayaan Masyarakat Jakarta Barat</span>
            </a>

            <div class="nav-links">
                <a href="{{ route('beranda') }}" class="nav-item {{ request()->routeIs('beranda') ? 'is-active' : '' }}">Beranda</a>
                <a href="{{ route('beranda') }}#tentang" class="nav-item">Tentang</a>
                <a href="{{ route('beranda') }}#pelatihan" class="nav-item">Pelatihan</a>
                <a href="{{ route('beranda') }}#informasi" class="nav-item">Informasi</a>
            </div>
        </div>
    </nav>

    <!-- KONTEN DINAMIS -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer" id="informasi">
        <div class="footer-container">
            <p class="footer-copy">&copy; {{ date('Y') }} Pemerintah Kota Administrasi Jakarta Barat. Hak Cipta Dilindungi.</p>
            <div class="footer-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat &amp; Ketentuan</a>
                <a href="#">Kontak Kami</a>
                <a href="https://jakarta.go.id" target="_blank" rel="noopener">Portal Jakarta</a>
            </div>
        </div>
    </footer>

</body>
</html>
