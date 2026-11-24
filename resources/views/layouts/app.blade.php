<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Laundry Express')</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='16' fill='%230284c7'/%3E%3Ccircle cx='32' cy='35' r='16' fill='none' stroke='%23ffffff' stroke-width='4'/%3E%3Cpath d='M20 35c3-4 8-4 12 0s9 4 12 0' fill='none' stroke='%2338bdf8' stroke-width='3.5' stroke-linecap='round'/%3E%3Ccircle cx='22' cy='16' r='2.5' fill='%23ffffff'/%3E%3Ccircle cx='30' cy='16' r='2.5' fill='%23bae6fd'/%3E%3C/svg%3E">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --laundry-primary: #0284c7;
            --laundry-sky: #0ea5e9;
            --laundry-cyan: #06b6d4;
            --laundry-ice: #e0f2fe;
            --laundry-navy: #0c4a6e;
        }
        body {
            background: linear-gradient(180deg, #e0f2fe 0%, #f0f9ff 30%, #f8fafc 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            color: #1e293b;
        }
        body.login-page {
            background: linear-gradient(135deg, #bae6fd 0%, #7dd3fc 45%, #38bdf8 100%);
        }
        @keyframes laundryWave {
            0%, 100% { transform: translateX(-1.5px) translateY(0px); }
            50% { transform: translateX(1.5px) translateY(-1.5px); }
        }
        @keyframes drumSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes bubbleFloat {
            0%, 100% { transform: translateY(0px) scale(1); opacity: 0.9; }
            50% { transform: translateY(-3px) scale(1.15); opacity: 0.5; }
        }
        .logo-wave {
            animation: laundryWave 2.2s ease-in-out infinite;
            transform-origin: center;
        }
        .logo-drum-ring {
            animation: drumSpin 8s linear infinite;
            transform-origin: 32px 38px;
        }
        .logo-bubble {
            animation: bubbleFloat 2.6s ease-in-out infinite;
            transform-origin: center;
        }
        main.main-content {
            flex: 1 0 auto;
        }
        .navbar {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 65%, #0369a1 100%);
            border-bottom: 3px solid #38bdf8;
            box-shadow: 0 4px 16px rgba(2, 132, 199, 0.22);
        }
        .navbar-brand {
            color: #ffffff !important;
            letter-spacing: -0.3px;
        }
        .brand-logo-box {
            background: #ffffff;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.14);
            flex-shrink: 0;
        }
        .card {
            border: 1px solid #bae6fd;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.07);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 26px rgba(2, 132, 199, 0.12);
        }
        .btn {
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.18s ease;
        }
        .btn:hover {
            transform: translateY(-1px);
        }
        .btn-primary {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            border-color: #0284c7;
            box-shadow: 0 3px 8px rgba(2, 132, 199, 0.25);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            border-color: #0369a1;
            box-shadow: 0 5px 14px rgba(2, 132, 199, 0.35);
        }
        .nav-menu-btn {
            border-radius: 50rem;
            padding: 0.42rem 0.95rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.28);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            transition: all 0.18s ease;
        }
        .nav-menu-btn:hover {
            background: rgba(255, 255, 255, 0.26);
            border-color: rgba(255, 255, 255, 0.55);
            transform: translateY(-1px);
            color: #ffffff !important;
        }
        .nav-menu-btn.active {
            background: #ffffff;
            color: #0284c7 !important;
            border-color: #ffffff;
            font-weight: 700;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.14);
        }
        .nav-menu-btn-accent {
            background: #fbbf24;
            color: #1e293b !important;
            border-color: #f59e0b;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        }
        .nav-menu-btn-accent:hover {
            background: #f59e0b;
            color: #0f172a !important;
            border-color: #d97706;
        }
        .nav-logout-btn {
            border-radius: 50rem;
            padding: 0.42rem 0.95rem;
            font-size: 0.85rem;
            font-weight: 600;
            background: rgba(15, 23, 42, 0.35);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.22);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            transition: all 0.18s ease;
        }
        .nav-logout-btn:hover {
            background: #ef4444;
            border-color: #dc2626;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(239, 68, 68, 0.35);
        }
        .user-chip {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 50rem;
            padding: 0.25rem 0.4rem 0.25rem 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
        }
        .table thead th, .table-light th {
            background-color: #e0f2fe !important;
            color: #0c4a6e !important;
            border-color: #bae6fd !important;
            font-weight: 700;
            font-size: 0.85rem;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border-color: #cbd5e1;
        }
        .form-control:focus, .form-select:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 0.2rem rgba(14, 165, 233, 0.2);
        }
        .badge-kategori {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 50rem;
        }
        .app-footer {
            background-color: #ffffff;
            border-top: 1px solid #bae6fd;
            color: #64748b;
        }
        @media (max-width: 991.98px) {
            .navbar-collapse {
                padding-top: 0.75rem;
                padding-bottom: 0.5rem;
            }
            .nav-menu-btn, .nav-logout-btn {
                width: 100%;
                justify-content: flex-start;
            }
            .user-chip {
                width: 100%;
                justify-content: space-between;
                padding: 0.4rem 0.75rem;
            }
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
            }
            .card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
        }
    </style>
</head>
<body class="{{ request()->routeIs('login') ? 'login-page' : '' }}">
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top py-2 mb-4 no-print">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
                <span class="brand-logo-box">
                    <svg width="28" height="28" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="8" y="6" width="48" height="52" rx="10" fill="#e0f2fe" stroke="#0284c7" stroke-width="4"/>
                        <line x1="8" y1="19" x2="56" y2="19" stroke="#0284c7" stroke-width="3.5"/>
                        <circle cx="19" cy="12.5" r="2.5" fill="#0284c7"/>
                        <circle cx="28" cy="12.5" r="2.5" fill="#0ea5e9"/>
                        <circle cx="44" cy="12.5" r="2.5" fill="#06b6d4"/>
                        <circle cx="32" cy="38" r="13" fill="#ffffff" stroke="#0284c7" stroke-width="3.5"/>
                        <circle class="logo-drum-ring" cx="32" cy="38" r="9.5" stroke="#bae6fd" stroke-width="2" stroke-dasharray="6 4"/>
                        <path class="logo-wave" d="M21 38c3-4 7-4 11 0s8 4 11 0" stroke="#0ea5e9" stroke-width="3.5" stroke-linecap="round"/>
                        <circle class="logo-bubble" cx="27" cy="32.5" r="2.2" fill="#38bdf8"/>
                    </svg>
                </span>
                <div class="d-flex flex-column lh-1">
                    <span class="fs-5 fw-bold">Laundry Express</span>
                    <span class="opacity-75 d-none d-sm-inline" style="font-size: 0.68rem; font-weight: 500;">Bersih, Wangi &amp; Terpercaya</span>
                </div>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <!-- Menu Navigasi di Sebelah Kiri -->
                <div class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center gap-2 me-auto ms-lg-3 mt-2 mt-lg-0">
                    @auth
                        @if(Auth::user()->isStaff())
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('dashboard') }}" class="nav-menu-btn {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                                <a href="{{ route('admin.services.index') }}" class="nav-menu-btn {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                                    <i class="bi bi-tags-fill"></i> Data Layanan
                                </a>
                                <a href="{{ route('admin.rekap') }}" class="nav-menu-btn {{ request()->routeIs('admin.rekap') ? 'active' : '' }}">
                                    <i class="bi bi-file-earmark-bar-graph-fill"></i> Rekap Transaksi
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="nav-menu-btn {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard Kasir
                                </a>
                                <a href="{{ route('home') }}" class="nav-menu-btn nav-menu-btn-accent">
                                    <i class="bi bi-plus-circle-fill"></i> Transaksi Baru
                                </a>
                                <a href="{{ route('admin.services.index') }}" class="nav-menu-btn {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                                    <i class="bi bi-tags-fill"></i> Data Layanan
                                </a>
                                <a href="{{ route('admin.rekap') }}" class="nav-menu-btn {{ request()->routeIs('admin.rekap') ? 'active' : '' }}">
                                    <i class="bi bi-file-earmark-bar-graph-fill"></i> Rekap Transaksi
                                </a>
                            @endif
                        @else
                            <a href="{{ route('home') }}" class="nav-menu-btn {{ request()->routeIs('home') ? 'active' : '' }}">
                                <i class="bi bi-basket2-fill"></i> Pesan Laundry
                            </a>
                            <a href="{{ route('customer.orders') }}" class="nav-menu-btn {{ request()->routeIs('customer.orders') ? 'active' : '' }}">
                                <i class="bi bi-clock-history"></i> Riwayat Pesanan
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="nav-menu-btn {{ request()->routeIs('login') ? 'active' : '' }}">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk (Login)
                        </a>
                        <a href="{{ route('register') }}" class="nav-menu-btn {{ request()->routeIs('register') ? 'active' : '' }}">
                            <i class="bi bi-person-plus-fill"></i> Daftar (Register)
                        </a>
                    @endauth
                </div>

                <!-- Profil & Logout di Sebelah Kanan -->
                @auth
                    <div class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center gap-2 ms-lg-auto mt-2 mt-lg-0">
                        <div class="user-chip">
                            <span class="d-inline-flex align-items-center gap-2">
                                <i class="bi bi-person-circle text-white"></i>
                                <span class="text-white small fw-medium">{{ Auth::user()->name }}</span>
                            </span>
                            @if(Auth::user()->isAdmin())
                                <span class="badge bg-white text-primary rounded-pill px-2 py-1">Admin</span>
                            @elseif(Auth::user()->isKasir())
                                <span class="badge bg-warning text-dark rounded-pill px-2 py-1">Kasir</span>
                            @else
                                <span class="badge bg-info text-dark rounded-pill px-2 py-1">Pelanggan</span>
                            @endif
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="d-grid d-lg-inline">
                            @csrf
                            <button class="nav-logout-btn">
                                <i class="bi bi-box-arrow-right"></i> Keluar (Log Out)
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container pb-5">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show no-print shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show no-print shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show no-print shadow-sm" role="alert">
                    <strong><i class="bi bi-exclamation-circle-fill me-2"></i>Perhatian:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="app-footer py-3 mt-auto no-print">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 small">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-water text-primary"></i>
                <span class="fw-semibold text-dark">Laundry Express</span>
                <span class="text-muted d-none d-sm-inline">• Sistem Informasi Manajemen Laundry</span>
            </div>
            <div class="text-muted text-center text-md-end">
                <i class="bi bi-clock me-1 text-primary"></i> Buka Setiap Hari: 07.00 – 21.00 WIB
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
