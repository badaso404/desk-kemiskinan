<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin') - Pemberdayaan Masyarakat Jakarta Barat</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
        body.admin-body {
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        /* SIDEBAR DESKTOP */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 260px;
            height: 100vh;
            background-color: #12395B;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 1000;
            overflow-y: auto;
            box-sizing: border-box;
            padding: 1.25rem 1rem;
            transition: transform 0.3s ease;
        }

        /* KONSISTENSI SERAGAM UNTUK SETIAP OPSI MENU NAVIGASI */
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            width: 100%;
            box-sizing: border-box;
        }

        .sidebar-nav .nav-link {
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
            width: 100% !important;
            padding: 0.75rem 1rem !important;
            border-radius: 10px !important;
            box-sizing: border-box !important;
            text-decoration: none;
            color: #94a3b8;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .sidebar-nav .nav-link svg {
            flex-shrink: 0;
            width: 20px;
            height: 20px;
        }

        .sidebar-nav .nav-link span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* EFFECT HOVER & ACTIVE SERAGAM */
        .sidebar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
        }

        .sidebar-nav .nav-link.is-active {
            background-color: rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
            font-weight: 600;
        }

        /* AREA UTAMA DESKTOP */
        .admin-main {
            margin-left: 260px;
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }

        .admin-content {
            padding: 2rem;
            flex: 1;
        }

        /* BACKDROP OVERLAY UNTUK MOBILE */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* TOPBAR NAVBAR KHUSUS MOBILE */
        .mobile-topbar {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 1.25rem;
            align-items: center;
            justify-content: space-between;
            z-index: 900;
        }

        .mobile-topbar-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-toggle-sidebar {
            background: transparent;
            border: none;
            color: #1e293b;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-brand-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #12395B;
        }

        /* MEDIA QUERIES RESPONSIVE MOBILE (< 768px) */
        @media (max-width: 768px) {
            .mobile-topbar {
                display: flex;
            }

            .sidebar-overlay.show {
                display: block;
                opacity: 1;
            }

            .admin-sidebar {
                transform: translateX(-100%);
                width: 270px;
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
                padding-top: 60px;
            }

            .admin-content {
                padding: 1.25rem;
            }

            /* MEMASTIKAN LEBAR DAN PADDING HOVER TETAP KONSISTEN DI MOBILE */
            .sidebar-nav .nav-link {
                padding: 0.8rem 1rem !important;
            }
        }
    </style>
</head>
<body class="admin-body">

    <!-- OVERLAY BACKDROP MOBILE -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- HEADER TOPBAR MOBILE -->
    <header class="mobile-topbar">
        <div class="mobile-topbar-left">
            <button type="button" class="btn-toggle-sidebar" id="sidebarToggle" aria-label="Buka Menu">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="mobile-brand-title">Desk Kemiskinan</div>
        </div>
        <img src="{{ asset('images/Logo-Jakarta.png') }}" alt="Logo Jakbar" style="width: 32px; height: 32px; object-fit: contain;">
    </header>

    <!-- SIDEBAR UTAMA -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <div class="brand-logo">
                <img src="{{ asset('images/Logo-Jakarta.png') }}" alt="Logo App" style="width: 36px; height: 36px; object-fit: contain;">
            </div>
            <div class="brand-text">
                <strong>Panel Admin</strong>
                <span>Kota Jakarta Barat</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.masyarakat') }}" class="nav-link {{ request()->routeIs('admin.masyarakat*') ? 'is-active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M12 4 2 9l10 5 10-5-10-5Z"/><path d="M6 12v4c0 1.1 2.7 2.5 6 2.5s6-1.4 6-2.5v-4"/>
                </svg>
                <span>Data Masyarakat</span>
            </a>
            <a href="{{ route('admin.pemberdayaan') }}" class="nav-link {{ request()->routeIs('admin.pemberdayaan') ? 'is-active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.2"/>
                    <path d="M3 19c0-3 2.7-5 6-5s6 2 6 5"/><path d="M17 14c2.3 0 4 1.6 4 4"/>
                </svg>
                <span>Pemberdayaan</span>
            </a>
            <a href="{{ route('admin.rekomendasi.index') }}" class="nav-link {{ request()->routeIs('admin.rekomendasi*') ? 'is-active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                <span>Rekomendasi Program</span>
            </a>
            <a href="{{ route('penempatan.index') }}" class="nav-link {{ request()->routeIs('penempatan.*') ? 'is-active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="3" width="18" height="18" rx="2.5"/>
                    <path d="M8 16v-5M12 16v-8M16 16v-3"/>
                </svg>
                <span>Penempatan</span>
            </a>
            <a href="{{ route('admin.monitoring') }}" class="nav-link {{ request()->routeIs('admin.monitoring*') ? 'is-active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"/>
                    <path d="M22 12A10 10 0 0 0 12 2v10z"/>
                </svg>
                <span>Monitoring</span>
            </a>
            <a href="{{ route('admin.audit-trail') }}" class="nav-link {{ request()->routeIs('admin.audit-trail') ? 'is-active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 12h6l3-7 3 14 2-7h3"/>
                </svg>
                <span>Audit Trail</span>
            </a>
            <a href="#" class="nav-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.6 1.6 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.6 1.6 0 0 0-2.7 1.1V21a2 2 0 1 1-4 0v-.1A1.6 1.6 0 0 0 7.9 19.4l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1A1.6 1.6 0 0 0 3 13.9H3a2 2 0 1 1 0-4h.1A1.6 1.6 0 0 0 4.6 7.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.6 1.6 0 0 0 2.7-1.1V4a2 2 0 1 1 4 0v.1a1.6 1.6 0 0 0 2.7 1.1l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.6 1.6 0 0 0 1.1 2.7H21a2 2 0 1 1 0 4h-.1a1.6 1.6 0 0 0-1.5 1Z"/>
                </svg>
                <span>Pengaturan</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="#" class="btn-bantuan">Bantuan Teknis</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-keluar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- AREA UTAMA -->
    <div class="admin-main">
        <main class="admin-content">
            @yield('content')
        </main>
    </div>

    <!-- SCRIPT INTERAKSI TOGGLE MOBILE -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const adminSidebar = document.getElementById('adminSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                adminSidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
            }

            if (sidebarToggle) sidebarToggle.addEventListener('click', toggleSidebar);
            if (sidebarOverlay) sidebarOverlay.addEventListener('click', toggleSidebar);
        });
    </script>
</body>
</html>
