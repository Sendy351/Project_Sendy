<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JasaKita') - Platform Jasa Mahasiswa & Solusi Area Kampus</title>
    
    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --bg-page: #F8FAFC;
            --bg-surface: #FFFFFF;
            --bg-subtle: #F1F5F9;
            --border: #E2E8F0;
            --border-hover: #CBD5E1;
            --primary: #2563EB;
            --primary-hover: #1D4ED8;
            --primary-light: #EFF6FF;
            --accent: #047857; /* audit: #10B981 kontrasnya cuma ~2.3:1 sebagai teks */
            --accent-light: #ECFDF5;
            --amber: #B45309; /* audit: #D97706 ~3:1 di atas amber-light */
            --amber-light: #FFFBEB;
            --rose: #BE123C;
            --rose-light: #FFF1F2;
            --text-main: #0F172A;
            --text-secondary: #475569;
            --text-muted: #64748B;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 10px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 12px 24px -4px rgba(0, 0, 0, 0.06);
            --radius-card: 16px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* Top Bar Info */
        .top-info-bar {
            background: #FFFFFF;
            border-bottom: 1px solid var(--border);
            padding: 7px 1.5rem;
            font-size: 0.775rem;
            color: var(--text-muted);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Main Navbar (scoped: jangan kena ke .mobile-bottom-bar yang juga <nav>) */
        nav.main-nav {
            background: #FFFFFF;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 50;
            padding: 0.75rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .nav-inner {
            max-width: 1240px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .brand-logo {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #2563EB, #1D4ED8);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.15rem;
            box-shadow: 0 3px 8px rgba(37, 99, 235, 0.25);
        }

        .brand-name {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .brand-name span {
            color: var(--primary);
        }

        .brand-tagline {
            font-size: 0.7rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
            list-style: none;
        }

        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            padding: 0.5rem 0.85rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link:hover {
            color: var(--primary);
            background: var(--primary-light);
        }

        .nav-link.active {
            color: var(--primary);
            background: var(--primary-light);
            font-weight: 700;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-pill {
            background: #FFFFFF;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 4px 10px 4px 6px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: var(--shadow-sm);
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: white;
        }

        .role-tag {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .role-admin { background: var(--rose-light); color: var(--rose); border: 1px solid #FECDD3; }
        .role-penyedia { background: var(--amber-light); color: var(--amber); border: 1px solid #FDE68A; }
        .role-pelanggan { background: var(--accent-light); color: var(--accent); border: 1px solid #A7F3D0; }

        /* Mobile Hamburger Toggle */
        .mobile-toggle {
            display: none;
            background: none;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 6px 10px;
            color: var(--text-main);
            font-size: 1.1rem;
            cursor: pointer;
        }

        .mobile-menu {
            display: none;
            flex-direction: column;
            gap: 6px;
            padding: 1rem 0 0.5rem;
            border-top: 1px solid var(--border);
            margin-top: 0.75rem;
            width: 100%;
        }

        .mobile-menu.active {
            display: flex;
        }

        /* Container */
        .main-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 2rem 1.25rem;
            flex: 1;
            width: 100%;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0.65rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-emerald {
            background: var(--accent);
            color: white;
            box-shadow: 0 2px 6px rgba(16, 185, 129, 0.2);
        }

        .btn-emerald:hover {
            background: #065F46;
            transform: translateY(-1px);
        }

        .btn-outline {
            background: #FFFFFF;
            border: 1px solid var(--border);
            color: var(--text-main);
        }

        .btn-outline:hover {
            background: var(--bg-subtle);
            border-color: var(--border-hover);
        }

        .btn-sm {
            padding: 0.45rem 0.85rem;
            font-size: 0.8rem;
            border-radius: 8px;
        }

        /* Card Panels */
        .card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-card);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
        }

        .card:hover {
            border-color: var(--border-hover);
            box-shadow: var(--shadow-md);
        }

        /* Alerts */
        .alert {
            padding: 0.9rem 1.2rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-sm);
        }

        .alert-success {
            background: var(--accent-light);
            border: 1px solid #A7F3D0;
            color: #065F46;
        }

        .alert-danger {
            background: var(--rose-light);
            border: 1px solid #FECDD3;
            color: #9F1239;
        }

        /* Footer */
        footer {
            background: #FFFFFF;
            border-top: 1px solid var(--border);
            padding: 1.75rem 1.5rem;
            text-align: center;
            font-size: 0.825rem;
            color: var(--text-muted);
            margin-top: auto;
        }

        /* ===== Audit UI: aksesibilitas & state global ===== */
        /* Fokus terlihat jelas (banyak input pakai outline:none inline) */
        input:not([type=radio]):not([type=checkbox]):focus,
        select:focus,
        textarea:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
        }
        a:focus-visible,
        button:focus-visible,
        .btn:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }
        input[type=radio],
        input[type=checkbox] {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }
        /* State loading untuk tombol submit (anti double-submit) */
        .btn.is-loading {
            opacity: 0.75;
            pointer-events: none;
        }
        .btn[disabled] {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }
        /* Link "Kembali" kecil biar gampang di-tap */
        .back-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            min-height: 44px;
            padding-right: 8px;
        }
        .back-link:hover { color: var(--primary); }

        /* Tombol tutup modal (×) */
        .modal-close {
            background: var(--bg-subtle);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: var(--text-secondary);
            font-size: 1.3rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .modal-close:hover { background: var(--border); color: var(--text-main); }

        /* Pagination (view bawaan Laravel butuh Tailwind yang gak di-load di layout ini) */
        .pager {
            display: flex;
            justify-content: center;
            gap: 8px;
            list-style: none;
            flex-wrap: wrap;
        }
        .pager a, .pager span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            min-height: 44px;
            padding: 0 14px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: #FFFFFF;
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
        }
        .pager span { color: var(--text-muted); background: var(--bg-subtle); }
        .pager a:hover { border-color: var(--primary); color: var(--primary); }

        /* Grid form 2 kolom -> 1 kolom di layar sempit */
        @media (max-width: 540px) {
            .form-grid-2 { grid-template-columns: 1fr !important; }
        }

        /* Media Queries for Mobile Responsiveness */
        @media (max-width: 868px) {
            body {
                padding-bottom: calc(76px + env(safe-area-inset-bottom)); /* Space for mobile bottom bar */
            }
            .nav-links {
                display: none;
            }
            .mobile-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 44px;
                height: 44px;
                padding: 0;
            }
            .top-info-bar {
                display: none;
            }
            nav.main-nav {
                padding: 0.6rem 1rem;
            }
            .nav-inner {
                flex-wrap: wrap;
            }
            /* Header HP: cukup logo + avatar + hamburger. Aksi lain ada di bottom bar / menu */
            .brand-tagline,
            .nav-actions .nav-cta,
            .nav-actions .user-pill-text,
            .nav-actions .nav-logout,
            .nav-actions .nav-guest-login {
                display: none !important;
            }
            .user-pill {
                padding: 4px;
            }
            .nav-actions .btn-sm {
                min-height: 44px;
            }
            .main-container {
                padding: 1.25rem 1rem;
            }
            .mobile-bottom-bar {
                display: flex !important;
            }
            /* Tap target minimal ~44px di layar sentuh */
            .btn {
                min-height: 44px;
            }
            /* Cegah iOS auto-zoom saat fokus input (font < 16px) */
            input:not([type=radio]):not([type=checkbox]),
            select,
            textarea {
                font-size: 16px !important;
            }
            .mobile-menu .nav-link {
                min-height: 48px;
                font-size: 0.95rem;
            }
        }

        /* Mobile Bottom App Navigation Bar */
        .mobile-bottom-bar {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-top: 1px solid var(--border);
            z-index: 99;
            padding: 6px 8px calc(8px + env(safe-area-inset-bottom));
            justify-content: space-around;
            align-items: flex-end;
            box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.05);
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            gap: 3px;
            text-decoration: none;
            color: var(--text-secondary);
            font-size: 0.72rem;
            font-weight: 600;
            transition: color 0.2s;
            position: relative;
            flex: 1;
            min-width: 0;
            min-height: 48px;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        .bottom-nav-item i {
            font-size: 1.15rem;
        }

        .bottom-nav-item.active {
            color: var(--primary);
            font-weight: 700;
        }

        .bottom-nav-item.active i {
            transform: scale(1.1);
        }

        .bottom-nav-fab {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #2563EB, #1D4ED8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white !important;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
            margin-top: -16px;
            border: 3px solid #FFFFFF;
        }

        /* Pulsing Dot Indicator */
        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--accent);
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            background-color: #10B981;
            animation: pulse-ring 1.8s infinite;
        }

        .pulse-dot.blue {
            background-color: var(--primary);
            box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.7);
            animation: pulse-ring-blue 1.8s infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        @keyframes pulse-ring-blue {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(37, 99, 235, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0);
            }
        }

        /* SweetAlert2 Modern Styling */
        .swal2-popup {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 20px !important;
            padding: 1.75rem !important;
            box-shadow: 0 25px 35px -5px rgba(15, 23, 42, 0.15), 0 10px 15px -5px rgba(15, 23, 42, 0.08) !important;
            border: 1px solid var(--border) !important;
        }
        .swal2-title {
            font-weight: 800 !important;
            font-size: 1.25rem !important;
            color: #0F172A !important;
            letter-spacing: -0.3px !important;
        }
        .swal2-html-container {
            font-size: 0.9rem !important;
            color: #475569 !important;
            line-height: 1.55 !important;
        }
        .swal2-confirm {
            border-radius: 10px !important;
            font-weight: 700 !important;
            padding: 0.65rem 1.4rem !important;
            font-size: 0.875rem !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25) !important;
        }
        .swal2-cancel {
            border-radius: 10px !important;
            font-weight: 700 !important;
            padding: 0.65rem 1.4rem !important;
            font-size: 0.875rem !important;
        }
        .swal2-popup.swal2-toast {
            padding: 0.75rem 1rem !important;
            border-radius: 14px !important;
        }
        .swal2-popup.swal2-toast .swal2-title {
            font-size: 0.875rem !important;
            font-weight: 700 !important;
            letter-spacing: 0 !important;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Top Info Bar Kampus -->
    <div class="top-info-bar">
        <div>
            <i class="fa-solid fa-graduation-cap" style="color: var(--primary);"></i> 
            <span>Layanan Kebutuhan Harian & Akademik Khusus Lingkungan Kampus</span>
        </div>
        <div>
            <i class="fa-solid fa-clock" style="color: #64748B;"></i> Layanan Aktif: 07.00 - 22.00 WIB
        </div>
    </div>

    <!-- Main Navbar -->
    <nav class="main-nav">
        <div class="nav-inner" style="flex-wrap: wrap;">
            <a href="{{ route('home') }}" class="nav-brand">
                <div class="brand-logo"><i class="fa-solid fa-bolt"></i></div>
                <div>
                    <div class="brand-name">Jasa<span>Kita</span></div>
                    <div class="brand-tagline">Campus On-Demand Network</div>
                </div>
            </a>

            <!-- Desktop Links -->
            <ul class="nav-links">
                <li>
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fa-solid fa-bolt" style="color: var(--primary);"></i> Pool Orderan
                    </a>
                </li>
                <li>
                    <a href="{{ route('jasa.index') }}" class="nav-link {{ request()->routeIs('jasa.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-layer-group"></i> Panduan Tarif
                    </a>
                </li>
                <li>
                    <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-tags"></i> Kategori
                    </a>
                </li>
                @auth
                <li>
                    <a href="{{ route('pesanan.index') }}" class="nav-link {{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-receipt"></i> Pesanan Saya
                    </a>
                </li>
                @if(Auth::user()->isPenyedia() || Auth::user()->isAdmin())
                <li>
                    <a href="{{ route('jasa.create') }}" class="nav-link {{ request()->routeIs('jasa.create') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Jasa
                    </a>
                </li>
                @endif
                @endauth
            </ul>

            <!-- Right Actions -->
            <div class="nav-actions">
                @auth
                    @if(!request()->routeIs('home'))
                        <a href="{{ route('home') }}#buat-order" class="btn btn-primary btn-sm nav-cta">
                            <i class="fa-solid fa-plus-circle"></i> Buat Orderan
                        </a>
                    @endif
                    <div class="user-pill" title="{{ Auth::user()->nama }} ({{ Auth::user()->peran }})">
                        <div class="user-avatar" aria-hidden="true">{{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}</div>
                        <div class="user-pill-text" style="line-height: 1.1;">
                            <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-main);">{{ Str::limit(Auth::user()->nama, 12) }}</div>
                            <span class="role-tag role-{{ Auth::user()->peran }}">{{ Auth::user()->peran }}</span>
                        </div>
                    </div>
                    <form class="nav-logout" action="{{ route('logout') }}" method="POST" style="display: inline;" onsubmit="return confirmSwal(this, { title: 'Konfirmasi Keluar', text: 'Apakah Anda yakin ingin keluar dari akun?', icon: 'question', confirmButtonText: 'Ya, Keluar' });">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm" title="Keluar" aria-label="Keluar">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm nav-guest-login">
                        <i class="fa-solid fa-right-to-bracket"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-user-plus"></i> Daftar
                    </a>
                @endauth

                <!-- Hamburger Button for Mobile -->
                <button type="button" class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Buka menu" aria-controls="mobileNavMenu" aria-expanded="false" id="mobileMenuToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <!-- Mobile Dropdown Menu (label disamakan dengan menu desktop) -->
            <div class="mobile-menu" id="mobileNavMenu">
                @auth
                <div style="display: flex; align-items: center; gap: 10px; padding: 0.25rem 0.85rem 0.75rem;">
                    <div class="user-avatar" style="width: 36px; height: 36px; font-size: 0.9rem;" aria-hidden="true">{{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}</div>
                    <div style="line-height: 1.2;">
                        <div style="font-size: 0.9rem; font-weight: 700; color: var(--text-main);">{{ Auth::user()->nama }}</div>
                        <span class="role-tag role-{{ Auth::user()->peran }}">{{ Auth::user()->peran }}</span>
                    </div>
                </div>
                @endauth
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fa-solid fa-bolt" style="color: var(--primary);"></i> Pool Orderan
                </a>
                <a href="{{ route('jasa.index') }}" class="nav-link {{ request()->routeIs('jasa.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group"></i> Panduan Tarif
                </a>
                <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-tags"></i> Kategori
                </a>
                @auth
                <a href="{{ route('pesanan.index') }}" class="nav-link {{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-receipt"></i> Pesanan Saya
                </a>
                @if(Auth::user()->isPenyedia() || Auth::user()->isAdmin())
                <a href="{{ route('jasa.create') }}" class="nav-link {{ request()->routeIs('jasa.create') ? 'active' : '' }}">
                    <i class="fa-solid fa-circle-plus"></i> Tambah Jasa
                </a>
                @endif
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirmSwal(this, { title: 'Konfirmasi Keluar', text: 'Apakah Anda yakin ingin keluar dari akun?', icon: 'question', confirmButtonText: 'Ya, Keluar' });">
                    @csrf
                    <button type="submit" class="nav-link" style="width: 100%; border: none; background: none; cursor: pointer; color: var(--rose); font-family: inherit;">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="nav-link">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk
                </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="main-container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check" style="font-size: 1.1rem; color: #10B981;"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fa-solid fa-circle-exclamation" style="font-size: 1.1rem; color: #E11D48;"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 1.1rem; color: #E11D48;"></i>
                <div>
                    <strong>Mohon periksa kesalahan berikut:</strong>
                    <ul style="margin-left: 1.25rem; margin-top: 4px;">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 <strong>JasaKita</strong> — Solusi Praktis Kebutuhan Jasa di Lingkungan Kampus.</p>
        <p style="margin-top: 4px; font-size: 0.775rem; color: var(--text-muted);">
            Layanan print skripsi, titip makan kantin, servis laptop, dan bantuan akademik terpercaya.
        </p>
    </footer>

    <!-- Mobile App Bottom Navigation Bar -->
    <nav class="mobile-bottom-bar" aria-label="Mobile Navigation">
        <a href="{{ route('home') }}" class="bottom-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fa-solid fa-bolt"></i>
            <span>Pool Order</span>
        </a>

        <a href="{{ route('jasa.index') }}" class="bottom-nav-item {{ request()->routeIs('jasa.index') ? 'active' : '' }}">
            <i class="fa-solid fa-layer-group"></i>
            <span>Tarif</span>
        </a>

        @auth
            <a href="{{ route('home') }}#buat-order" onclick="if(typeof openCreateModal === 'function'){ openCreateModal(); return false; }" class="bottom-nav-item" title="Buat Orderan">
                <div class="bottom-nav-fab">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <span style="margin-top: 2px;">Buat Order</span>
            </a>

            <a href="{{ route('pesanan.index') }}" class="bottom-nav-item {{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
                <i class="fa-solid fa-receipt"></i>
                <span>Pesanan</span>
            </a>

            {{-- Sebelumnya "Akun" cuma link ke halaman Pesanan (duplikat). Sekarang buka menu akun (profil + keluar). --}}
            <button type="button" class="bottom-nav-item" onclick="toggleMobileMenu(true)" aria-controls="mobileNavMenu">
                <i class="fa-solid fa-circle-user"></i>
                <span>Akun</span>
            </button>
        @else
            <a href="{{ route('login') }}" class="bottom-nav-item {{ request()->routeIs('login') ? 'active' : '' }}" title="Masuk">
                <div class="bottom-nav-fab">
                    <i class="fa-solid fa-right-to-bracket"></i>
                </div>
                <span style="margin-top: 2px;">Masuk</span>
            </a>

            <a href="{{ route('kategori.index') }}" class="bottom-nav-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i>
                <span>Kategori</span>
            </a>

            {{-- Sebelumnya tombol "Masuk" muncul dua kali. Item terakhir sekarang "Daftar". --}}
            <a href="{{ route('register') }}" class="bottom-nav-item {{ request()->routeIs('register') ? 'active' : '' }}">
                <i class="fa-solid fa-user-plus"></i>
                <span>Daftar</span>
            </a>
        @endauth
    </nav>

    <script>
        function toggleMobileMenu(forceOpen) {
            const menu = document.getElementById('mobileNavMenu');
            const toggle = document.getElementById('mobileMenuToggle');
            const open = forceOpen === true ? true : !menu.classList.contains('active');
            menu.classList.toggle('active', open);
            if (toggle) {
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                toggle.innerHTML = open ? '<i class="fa-solid fa-xmark"></i>' : '<i class="fa-solid fa-bars"></i>';
            }
            if (open && forceOpen === true) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        // Tombol submit -> state loading + cegah klik dobel
        function setFormLoading(formElement) {
            const btn = formElement.querySelector('button[type=submit], button:not([type])');
            if (!btn || btn.classList.contains('is-loading')) return;
            btn.classList.add('is-loading');
            btn.setAttribute('aria-busy', 'true');
            btn.dataset.originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
        }
        document.addEventListener('submit', function (e) {
            if (e.defaultPrevented || e.target.method?.toLowerCase() === 'get' || e.target.dataset.noLoading !== undefined) return;
            setFormLoading(e.target);
        });
        // Balikin tombol kalau user pencet Back (bfcache)
        window.addEventListener('pageshow', function () {
            document.querySelectorAll('.btn.is-loading').forEach(function (btn) {
                btn.classList.remove('is-loading');
                btn.removeAttribute('aria-busy');
                if (btn.dataset.originalHtml) btn.innerHTML = btn.dataset.originalHtml;
            });
        });

        // Semua modal (id="modal-...") bisa ditutup pakai Esc atau klik area gelap di luar
        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape') return;
            document.querySelectorAll('[id^="modal-"]').forEach(function (m) {
                if (m.style.display === 'flex') m.style.display = 'none';
            });
        });
        document.addEventListener('click', function (e) {
            if (e.target.id && e.target.id.startsWith('modal-') && e.target.style.display === 'flex') {
                e.target.style.display = 'none';
            }
        });

        // Global SweetAlert2 Confirmation Dialog Helper
        function confirmSwal(formElement, options = {}) {
            const title = options.title || 'Apakah Anda yakin?';
            const text = options.text || 'Tindakan ini tidak dapat dibatalkan.';
            const icon = options.icon || 'warning';
            const confirmButtonText = options.confirmButtonText || 'Ya, Lanjutkan';
            const confirmButtonColor = options.confirmButtonColor || '#2563EB';

            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: confirmButtonColor,
                cancelButtonColor: '#64748B',
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    setFormLoading(formElement);
                    formElement.submit();
                }
            });
            return false;
        }

        // Flash message: sebelumnya tiap pesan tampil DUA kali (alert di halaman + popup SweetAlert).
        // Sekarang: sukses = toast kecil yang hilang sendiri, error tetap jadi alert di halaman (gak ada popup dobel).
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                document.querySelectorAll('.main-container > .alert-success').forEach(function (el) { el.remove(); });
                Swal.fire({
                    toast: true,
                    position: window.innerWidth <= 868 ? 'top' : 'top-end',
                    icon: 'success',
                    title: @json(session('success')),
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
            @endif
        });
    </script>
    @yield('scripts')
</body>
</html>
