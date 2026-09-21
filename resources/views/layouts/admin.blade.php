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

        /* BRAND / LOGO SIDEBAR */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 0.5rem;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            color: #ffffff;
        }

        .brand-text strong {
            font-size: 0.95rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .brand-text span {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        /* WIDGET ROLE SWITCHER */
        .role-switcher-box {
            padding: 0.6rem 0.75rem;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            margin: 0.85rem 0;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .role-switcher-label {
            display: block;
            font-size: 0.68rem;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 0.35rem;
            letter-spacing: 0.5px;
        }

        .role-switcher-select {
            width: 100%;
            padding: 0.45rem 0.6rem;
            border-radius: 6px;
            background: #0b2238;
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.825rem;
            font-weight: 600;
            cursor: pointer;
            outline: none;
            font-family: inherit;
        }

        /* KONSISTENSI MENU NAVIGASI */
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

        /* FOOTER SIDEBAR */
        .sidebar-footer {
            margin-top: auto;
            padding-top: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-bantuan {
            color: #94a3b8;
            font-size: 0.8rem;
            text-decoration: none;
            padding: 0.4rem 0.5rem;
            transition: color 0.2s ease;
        }
        .btn-bantuan:hover { color: #ffffff; }

        .btn-keluar {
            width: 100%;
            background: transparent;
            border: none;
            color: #f87171;
            padding: 0.6rem 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.875rem;
            font-weight: 600;
            transition: background-color 0.2s ease;
        }
        .btn-keluar:hover { background-color: rgba(248, 113, 113, 0.12); }
        .btn-keluar svg { width: 18px; height: 18px; }

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

        /* RESPONSIVE MOBILE (< 768px) */
        @media (max-width: 768px) {
            .mobile-topbar { display: flex; }
            .sidebar-overlay.show { display: block; opacity: 1; }
            .admin-sidebar { transform: translateX(-100%); width: 270px; }
            .admin-sidebar.show { transform: translateX(0); }
            .admin-main { margin-left: 0; padding-top: 60px; }
            .admin-content { padding: 1.25rem; }
            .sidebar-nav .nav-link { padding: 0.8rem 1rem !important; }
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

    @php
        $userRole = auth()->user()->role ?? '';

        $brandTitles = [
            'admin'          => 'Panel Admin',
            'kecamatan'      => 'Panel Kecamatan',
            'pimpinan_kesra' => 'Panel Kesra',
            'kelurahan'      => 'Panel Kelurahan',
            'walikota'       => 'Panel Walikota',
        ];

        $currentBrandTitle = $brandTitles[$userRole] ?? 'Desk Kemiskinan';
    @endphp

    <!-- SIDEBAR UTAMA -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div>
            <!-- BRAND LOGO -->
            <div class="sidebar-brand">
                <div class="brand-logo">
                    <img src="{{ asset('images/Logo-Jakarta.png') }}" alt="Logo App" style="width: 36px; height: 36px; object-fit: contain;">
                </div>
                <div class="brand-text">
                    <strong>{{ $currentBrandTitle }}</strong>
                    <span>Kota Jakarta Barat</span>
                </div>
            </div>

            <!-- WIDGET ROLE SWITCHER (SIMULASI GANTI ROLE) -->
            <div class="role-switcher-box">
                <label class="role-switcher-label">Simulasi Role:</label>
                <form action="{{ route('switch.role') }}" method="POST">
                    @csrf
                    <select name="role" onchange="this.form.submit()" class="role-switcher-select">
                        <option value="admin" {{ $userRole === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kecamatan" {{ $userRole === 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                        <option value="pimpinan_kesra" {{ $userRole === 'pimpinan_kesra' ? 'selected' : '' }}>Pimpinan Kesra</option>
                        <option value="kelurahan" {{ $userRole === 'kelurahan' ? 'selected' : '' }}>Kelurahan</option>
                        <option value="walikota" {{ $userRole === 'walikota' ? 'selected' : '' }}>Walikota</option>
                    </select>
                </form>
            </div>

            @php
                $semuaRoleNonPenempatan = ['admin', 'kecamatan', 'pimpinan_kesra', 'kelurahan'];

                $menus = [
                    [
                        'title' => 'Dashboard',
                        'route' => 'admin.dashboard',
                        'active' => request()->routeIs('admin.dashboard'),
                        'roles' => ['admin', 'kecamatan', 'pimpinan_kesra', 'kelurahan', 'walikota'],
                        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>'
                    ],
                    [
                        'title' => 'Data Masyarakat',
                        'route' => 'admin.masyarakat',
                        'active' => request()->routeIs('admin.masyarakat*'),
                        'roles' => $semuaRoleNonPenempatan,
                        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 4 2 9l10 5 10-5-10-5Z"/><path d="M6 12v4c0 1.1 2.7 2.5 6 2.5s6-1.4 6-2.5v-4"/></svg>'
                    ],
                    [
                        'title' => 'Pemberdayaan',
                        'route' => 'admin.pemberdayaan',
                        'active' => request()->routeIs('admin.pemberdayaan*'),
                        'roles' => $semuaRoleNonPenempatan,
                        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.2"/><path d="M3 19c0-3 2.7-5 6-5s6 2 6 5"/><path d="M17 14c2.3 0 4 1.6 4 4"/></svg>'
                    ],
                    [
                        'title' => 'Rekomendasi Program',
                        'route' => 'admin.rekomendasi.index',
                        'active' => request()->routeIs('admin.rekomendasi*'),
                        'roles' => $semuaRoleNonPenempatan,
                        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>'
                    ],
                    [
                        'title' => 'Penempatan',
                        'route' => 'penempatan.index',
                        'active' => request()->routeIs('penempatan.*'),
                        'roles' => ['admin', 'walikota'],
                        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2.5"/><path d="M8 16v-5M12 16v-8M16 16v-3"/></svg>'
                    ],
                    [
                        'title' => 'Monitoring',
                        'route' => 'admin.monitoring',
                        'active' => request()->routeIs('admin.monitoring*'),
                        'roles' => ['admin', 'kecamatan', 'pimpinan_kesra', 'kelurahan', 'walikota'],
                        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>'
                    ],
                    [
                        'title' => 'Audit Trail',
                        'route' => 'admin.audit-trail',
                        'active' => request()->routeIs('admin.audit-trail'),
                        'roles' => ['admin'],
                        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 12h6l3-7 3 14 2-7h3"/></svg>'
                    ],
                    [
                        'title' => 'Pengaturan',
                        'route' => 'admin.dashboard',
                        'active' => false,
                        'roles' => ['admin'],
                        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.6 1.6 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.6 1.6 0 0 0-2.7 1.1V21a2 2 0 1 1-4 0v-.1A1.6 1.6 0 0 0 7.9 19.4l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1A1.6 1.6 0 0 0 3 13.9H3a2 2 0 1 1 0-4h.1A1.6 1.6 0 0 0 4.6 7.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.6 1.6 0 0 0 2.7-1.1V4a2 2 0 1 1 4 0v.1a1.6 1.6 0 0 0 2.7 1.1l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.6 1.6 0 0 0 1.1 2.7H21a2 2 0 1 1 0 4h-.1a1.6 1.6 0 0 0-1.5 1Z"/></svg>'
                    ],
                ];
            @endphp

            <!-- NAVIGASI MENU DINAMIS -->
            <nav class="sidebar-nav">
                @foreach ($menus as $menu)
                    @if (in_array($userRole, $menu['roles']))
                        <a href="{{ $menu['route'] !== '#' ? route($menu['route']) : '#' }}" class="nav-link {{ $menu['active'] ? 'is-active' : '' }}">
                            {!! $menu['icon'] !!}
                            <span>{{ $menu['title'] }}</span>
                        </a>
                    @endif
                @endforeach
            </nav>
        </div>

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