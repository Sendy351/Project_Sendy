<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jasa Kita - Campus P2P Micro-Errands & Jastip Mahasiswa</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #eff6ff;
            --emerald: #059669;
            --emerald-light: #ecfdf5;
            --amber: #d97706;
            --amber-light: #fffbeb;
            --dark: #0f172a;
            --slate-800: #1e293b;
            --slate-600: #475569;
            --slate-500: #64748b;
            --slate-200: #e2e8f0;
            --slate-100: #f1f5f9;
            --bg-page: #f8fafc;
            --radius-xl: 18px;
            --radius-lg: 14px;
            --radius-md: 10px;
            --shadow-card: 0 4px 14px rgba(15, 23, 42, 0.05);
            --shadow-hover: 0 10px 25px rgba(37, 99, 235, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-page);
            color: var(--dark);
            line-height: 1.6;
            padding-bottom: 60px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Top Bar Simulation */
        .simulation-bar {
            background: #0f172a;
            color: #94a3b8;
            padding: 8px 0;
            font-size: 0.8rem;
            border-bottom: 1px solid #334155;
        }

        .simulation-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-switcher {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-switcher select {
            background: #1e293b;
            color: #f8fafc;
            border: 1px solid #475569;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.8rem;
            outline: none;
            cursor: pointer;
        }

        /* Navbar */
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid var(--slate-200);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
        }

        .nav-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), #0284c7);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
        }

        .brand-text h2 {
            font-size: 1.2rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .badge-campus {
            background: #dbeafe;
            color: #1e40af;
            font-size: 0.65rem;
            padding: 2px 8px;
            border-radius: 6px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .brand-text p {
            font-size: 0.75rem;
            color: var(--slate-500);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .wallet-pill {
            background: var(--emerald-light);
            border: 1px solid #a7f3d0;
            padding: 8px 14px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--emerald);
            cursor: pointer;
            transition: all 0.2s;
        }

        .wallet-pill:hover {
            background: #d1fae5;
            transform: translateY(-1px);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-success {
            background: var(--emerald);
            color: #fff;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
        }

        .btn-success:hover {
            background: #047857;
        }

        .btn-secondary {
            background: #f1f5f9;
            color: var(--slate-800);
            border: 1px solid var(--slate-200);
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        /* Banner Hero Mini */
        .hero-banner {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0369a1 100%);
            color: #fff;
            padding: 32px 0;
            border-radius: var(--radius-xl);
            margin: 24px 0 32px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(30, 58, 138, 0.15);
        }

        .hero-banner-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }

        .hero-text h1 {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .hero-text p {
            font-size: 0.95rem;
            color: #cbd5e1;
            max-width: 620px;
        }

        .hero-stats {
            display: flex;
            gap: 24px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            padding: 16px 24px;
            border-radius: var(--radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .hero-stat-item {
            text-align: center;
        }

        .hero-stat-item .num {
            font-size: 1.4rem;
            font-weight: 800;
        }

        .hero-stat-item .lbl {
            font-size: 0.75rem;
            color: #93c5fd;
            font-weight: 600;
        }

        /* Navigation Tabs */
        .tabs-header {
            display: flex;
            gap: 8px;
            border-bottom: 2px solid var(--slate-200);
            margin-bottom: 24px;
        }

        .tab-link {
            padding: 12px 20px;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--slate-500);
            text-decoration: none;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .tab-link:hover {
            color: var(--primary);
        }

        .tab-link.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        .tab-count {
            background: #e2e8f0;
            color: #475569;
            font-size: 0.75rem;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .tab-link.active .tab-count {
            background: #dbeafe;
            color: var(--primary);
        }

        /* Filter & Search Bar */
        .feed-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .category-pills {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .pill-btn {
            background: #fff;
            border: 1px solid var(--slate-200);
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--slate-600);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .pill-btn:hover, .pill-btn.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .search-form {
            display: flex;
            gap: 8px;
            min-width: 300px;
        }

        .search-input {
            width: 100%;
            padding: 8px 16px;
            border-radius: 8px;
            border: 1px solid var(--slate-200);
            font-size: 0.85rem;
            outline: none;
        }

        .search-input:focus {
            border-color: var(--primary);
        }

        /* Task Cards Grid */
        .task-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 20px;
        }

        .task-card {
            background: #fff;
            border-radius: var(--radius-lg);
            border: 1px solid var(--slate-200);
            padding: 20px;
            box-shadow: var(--shadow-card);
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .task-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
            border-color: #cbd5e1;
        }

        .task-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .category-tag {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .cat-print { background: #eff6ff; color: #1d4ed8; }
        .cat-food { background: #fef2f2; color: #b91c1c; }
        .cat-goods { background: #f0fdf4; color: #15803d; }
        .cat-other { background: #f5f3ff; color: #6d28d9; }

        .status-badge {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
        }

        .st-open { background: #dbeafe; color: #1e40af; }
        .st-in_progress { background: #fef3c7; color: #b45309; }
        .st-delivered { background: #e0e7ff; color: #4338ca; }
        .st-completed { background: #dcfce7; color: #15803d; }

        .task-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .task-desc {
            font-size: 0.85rem;
            color: var(--slate-600);
            margin-bottom: 16px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Route Box (Pickup -> Dropoff) */
        .route-box {
            background: #f8fafc;
            border: 1px dashed var(--slate-200);
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 16px;
        }

        .route-point {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.8rem;
            margin-bottom: 6px;
        }

        .route-point:last-child {
            margin-bottom: 0;
        }

        .route-icon {
            width: 18px;
            text-align: center;
        }

        .route-point strong {
            color: var(--slate-800);
        }

        /* User Strip */
        .task-users {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.8rem;
            color: var(--slate-500);
            padding: 10px 0;
            border-top: 1px solid var(--slate-100);
            margin-bottom: 14px;
        }

        .user-info-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-avatar-mini {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--slate-600);
        }

        /* Task Footer */
        .task-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid var(--slate-100);
        }

        .tip-box {
            display: flex;
            flex-direction: column;
        }

        .tip-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--slate-500);
        }

        .tip-val {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--emerald);
        }

        .bailout-val {
            font-size: 0.75rem;
            color: var(--slate-500);
        }

        /* Alert / Messages */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        /* Modal Structure */
        .modal {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.active { display: flex; }

        .modal-content {
            background: #fff;
            border-radius: var(--radius-xl);
            max-width: 540px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            padding: 18px 24px;
            background: #f8fafc;
            border-bottom: 1px solid var(--slate-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            font-size: 1.15rem;
            font-weight: 800;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.4rem;
            color: var(--slate-500);
            cursor: pointer;
        }

        .modal-body {
            padding: 24px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--slate-800);
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid var(--slate-200);
            font-size: 0.9rem;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
    </style>
</head>
<body>

    <!-- Simulation Bar (Switch Mahasiswa) -->
    <div class="simulation-bar">
        <div class="container simulation-wrapper">
            <div>
                <i class="fa-solid fa-graduation-cap"></i> <strong>Jasa Kita</strong> &bull; Lingkungan Kampus
            </div>
            <form action="{{ route('tasks.switch_user') }}" method="POST" class="user-switcher">
                @csrf
                <span>Simulasi Login Sebagai:</span>
                <select name="user_id" onchange="this.form.submit()">
                    @foreach ($allUsers as $u)
                        <option value="{{ $u->id }}" {{ $currentUser->id === $u->id ? 'selected' : '' }}>
                            {{ $u->name }} (NIM: {{ $u->nim }})
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container nav-wrapper">
            <a href="{{ route('tasks.index') }}" class="brand-box">
                <div class="brand-icon">
                    <i class="fa-solid fa-person-running"></i>
                </div>
                <div class="brand-text">
                    <h2>Jasa Kita <span class="badge-campus">Kampus P2P</span></h2>
                    <p>Micro-Errands & Jastip Mahasiswa</p>
                </div>
            </a>

            <div class="nav-actions">
                <div class="wallet-pill" onclick="openModal('walletModal')">
                    <i class="fa-solid fa-wallet"></i>
                    <span>Rp {{ number_format($currentUser->wallet_balance, 0, ',', '.') }}</span>
                </div>

                <button class="btn btn-primary" onclick="openModal('createTaskModal')">
                    <i class="fa-solid fa-plus-circle"></i> Titip Tugas Baru
                </button>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Flash Alert -->
        @if (session('success'))
            <div class="alert alert-success" style="margin-top: 20px;">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error" style="margin-top: 20px;">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Hero Banner Stats -->
        <div class="hero-banner">
            <div class="container hero-banner-content">
                <div class="hero-text">
                    <h1>Lagi Sibuk di Kelas? Titip Teman Saja!</h1>
                    <p>Bantuan kilat cetak modul di lab, titip makan siang di kantin seberang, atau ambil barang ketinggalan. Saling bantu sesama mahasiswa!</p>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat-item">
                        <div class="num">{{ $stats['open_tasks'] }}</div>
                        <div class="lbl">Tugas Terbuka</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="num">{{ $stats['active_tasks'] }}</div>
                        <div class="lbl">Sedang Jalan</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="num">{{ $stats['completed_tasks'] }}</div>
                        <div class="lbl">Tuntas</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="num">Rp {{ number_format($stats['total_tips_paid'] / 1000, 0) }}k</div>
                        <div class="lbl">Tip Tersalurkan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="tabs-header">
            <a href="{{ route('tasks.index', ['tab' => 'feed']) }}" class="tab-link {{ $tab === 'feed' ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn"></i> Campus Task Feed 
                <span class="tab-count">{{ $stats['open_tasks'] }}</span>
            </a>
            <a href="{{ route('tasks.index', ['tab' => 'in_progress']) }}" class="tab-link {{ $tab === 'in_progress' ? 'active' : '' }}">
                <i class="fa-solid fa-spinner"></i> Sedang Berjalan 
                <span class="tab-count">{{ $stats['active_tasks'] }}</span>
            </a>
            <a href="{{ route('tasks.index', ['tab' => 'my_tasks']) }}" class="tab-link {{ $tab === 'my_tasks' ? 'active' : '' }}">
                <i class="fa-solid fa-user-check"></i> Tugas Saya
            </a>
            <a href="{{ route('tasks.index', ['tab' => 'completed']) }}" class="tab-link {{ $tab === 'completed' ? 'active' : '' }}">
                <i class="fa-solid fa-circle-check"></i> Riwayat Selesai 
                <span class="tab-count">{{ $stats['completed_tasks'] }}</span>
            </a>
        </div>

        <!-- Filter & Search Controls -->
        <div class="feed-controls">
            <div class="category-pills">
                <a href="{{ route('tasks.index', ['tab' => $tab]) }}" class="pill-btn {{ !request('category') ? 'active' : '' }}">
                    Semua
                </a>
                <a href="{{ route('tasks.index', ['tab' => $tab, 'category' => 'print_dokumen']) }}" class="pill-btn {{ request('category') === 'print_dokumen' ? 'active' : '' }}">
                    <i class="fa-solid fa-print"></i> Print Dokumen
                </a>
                <a href="{{ route('tasks.index', ['tab' => $tab, 'category' => 'titip_makanan']) }}" class="pill-btn {{ request('category') === 'titip_makanan' ? 'active' : '' }}">
                    <i class="fa-solid fa-burger"></i> Titip Makanan
                </a>
                <a href="{{ route('tasks.index', ['tab' => $tab, 'category' => 'ambil_barang']) }}" class="pill-btn {{ request('category') === 'ambil_barang' ? 'active' : '' }}">
                    <i class="fa-solid fa-box"></i> Ambil Barang
                </a>
            </div>

            <form action="{{ route('tasks.index') }}" method="GET" class="search-form">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari gedung / tugas..." class="search-input">
                <button type="submit" class="btn btn-secondary">
                    <i class="fa-solid fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Task Feed Grid -->
        <div class="task-grid">
            @forelse ($tasks as $task)
                @php
                    $catClass = match($task->category) {
                        'print_dokumen' => 'cat-print',
                        'titip_makanan' => 'cat-food',
                        'ambil_barang' => 'cat-goods',
                        default => 'cat-other',
                    };
                    $catIcon = match($task->category) {
                        'print_dokumen' => 'fa-print',
                        'titip_makanan' => 'fa-burger',
                        'ambil_barang' => 'fa-box',
                        default => 'fa-clipboard-list',
                    };
                @endphp

                <div class="task-card">
                    <div class="task-card-header">
                        <span class="category-tag {{ $catClass }}">
                            <i class="fa-solid {{ $catIcon }}"></i> {{ $task->category_label }}
                        </span>
                        <span class="status-badge st-{{ $task->status }}">
                            {{ strtoupper(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>

                    <h3 class="task-title">{{ $task->title }}</h3>
                    <p class="task-desc">{{ $task->description }}</p>

                    <!-- Route Point -->
                    <div class="route-box">
                        <div class="route-point">
                            <span class="route-icon" style="color: #ef4444;"><i class="fa-solid fa-circle-dot"></i></span>
                            <div>
                                <span style="font-size: 0.7rem; color: #64748b;">TITIK JEMPUT:</span><br>
                                <strong>{{ $task->pickup_location }}</strong>
                            </div>
                        </div>
                        <div class="route-point">
                            <span class="route-icon" style="color: #10b981;"><i class="fa-solid fa-location-dot"></i></span>
                            <div>
                                <span style="font-size: 0.7rem; color: #64748b;">TITIK ANTAR:</span><br>
                                <strong>{{ $task->dropoff_location }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- User Meta -->
                    <div class="task-users">
                        <div class="user-info-row">
                            <div class="user-avatar-mini">{{ substr($task->requester->name, 0, 1) }}</div>
                            <div>
                                <div style="font-weight: 700; color: #1e293b;">{{ $task->requester->name }}</div>
                                <div style="font-size: 0.7rem;">Requester (NIM: {{ $task->requester->nim }})</div>
                            </div>
                        </div>

                        @if ($task->runner)
                            <div class="user-info-row" style="text-align: right;">
                                <div>
                                    <div style="font-weight: 700; color: #059669;">{{ $task->runner->name }}</div>
                                    <div style="font-size: 0.7rem;">Runner Terpilih</div>
                                </div>
                                <div class="user-avatar-mini" style="background:#d1fae5; color:#059669;">{{ substr($task->runner->name, 0, 1) }}</div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Footer -->
                    <div class="task-card-footer">
                        <div class="tip-box">
                            <span class="tip-label">Ongkos Tip Runner</span>
                            <span class="tip-val">+ Rp {{ number_format($task->tip_amount, 0, ',', '.') }}</span>
                            @if ($task->item_price > 0)
                                <span class="bailout-val">Talangan: Rp {{ number_format($task->item_price, 0, ',', '.') }}</span>
                            @endif
                        </div>

                        <!-- Tombol Aksi Berdasarkan Status & Role -->
                        @if ($task->status === 'open')
                            @if ($currentUser->id !== $task->requester_id)
                                <form action="{{ route('tasks.claim', $task->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-hand-holding-dollar"></i> Ambil Order
                                    </button>
                                </form>
                            @else
                                <span style="font-size: 0.8rem; color: #64748b; font-style: italic;">
                                    <i class="fa-solid fa-clock"></i> Tugas buatanmu
                                </span>
                            @endif

                        @elseif (in_array($task->status, ['taken', 'in_progress']))
                            @if ($currentUser->id === $task->runner_id)
                                <button class="btn btn-primary" onclick="openProofModal('{{ $task->id }}', '{{ $task->title }}')">
                                    <i class="fa-solid fa-camera"></i> Kirim Bukti
                                </button>
                            @else
                                <span style="font-size: 0.8rem; color: #b45309; font-weight: 600;">
                                    <i class="fa-solid fa-person-running"></i> Runner sedang jalan
                                </span>
                            @endif

                        @elseif ($task->status === 'delivered')
                            @if ($currentUser->id === $task->requester_id)
                                <button class="btn btn-success" onclick="openCompleteModal('{{ $task->id }}', '{{ $task->title }}', '{{ $task->tip_amount }}', '{{ $task->runner->name }}')">
                                    <i class="fa-solid fa-circle-check"></i> Konfirmasi Selesai
                                </button>
                            @elseif ($currentUser->id === $task->runner_id)
                                <span style="font-size: 0.8rem; color: #4338ca; font-weight: 600;">
                                    <i class="fa-solid fa-hourglass-half"></i> Menunggu Konfirmasi
                                </span>
                            @endif

                        @elseif ($task->status === 'completed')
                            <div style="font-size: 0.8rem; color: #059669; font-weight: 700;">
                                <i class="fa-solid fa-check-double"></i> Tip Sudah Cair
                                @if ($task->reviews->isNotEmpty())
                                    <span style="color: #f59e0b; margin-left: 6px;">★ {{ $task->reviews->first()->rating }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #fff; border-radius: var(--radius-xl); border: 1px dashed var(--slate-200);">
                    <i class="fa-solid fa-inbox" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 14px;"></i>
                    <h3 style="color: #475569; margin-bottom: 6px;">Belum ada tugas di kategori/tab ini</h3>
                    <p style="color: #94a3b8; font-size: 0.9rem;">Mau titip bantuan sesuatu ke teman kampus? Klik tombol Titip Tugas Baru di atas!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal 1: Buat Tugas Baru (Requester) -->
    <div class="modal" id="createTaskModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa-solid fa-plus-circle" style="color: var(--primary);"></i> Buat Order Tugas Baru</h3>
                <button class="modal-close" onclick="closeModal('createTaskModal')">&times;</button>
            </div>
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kategori Bantuan</label>
                        <select name="category" class="form-control" required>
                            <option value="print_dokumen">Print Dokumen (Laporan/Makalah/Skripsi)</option>
                            <option value="titip_makanan">Titip Makanan (Kantin/Kopma/Warung Kampus)</option>
                            <option value="ambil_barang">Ambil Barang (Modul/Buku/Kunci/Paket)</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Judul Tugas (Singkat & Jelas)</label>
                        <input type="text" name="title" class="form-control" required placeholder="Contoh: Titip Print Laporan 10 Lbr di Lab Komputer Gedung C">
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label>Titik Penjemputan (Pickup)</label>
                            <input type="text" name="pickup_location" class="form-control" required placeholder="Contoh: Lab Komputer Lt. 2">
                        </div>
                        <div class="form-group">
                            <label>Titik Pengantaran (Drop-off)</label>
                            <input type="text" name="dropoff_location" class="form-control" required placeholder="Contoh: Gedung B Ruang 304">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label>Biaya Talangan Barang (Rp)</label>
                            <input type="number" name="item_price" class="form-control" value="0" min="0" placeholder="0 jika tidak ada barang yang dibeli">
                            <small style="color: #64748b; font-size: 0.75rem;">Contoh: harga print / harga makanan</small>
                        </div>
                        <div class="form-group">
                            <label>Ongkos Jasa / Tip Runner (Rp)</label>
                            <input type="number" name="tip_amount" class="form-control" value="5000" min="2000" step="1000" required>
                            <small style="color: #059669; font-size: 0.75rem; font-weight: 600;">Uang saku untuk teman yang membantu</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Instruksi / Catatan Tambahan</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Contoh: Tolong print warna, jilid lakban hitam. Saya tunggu sebelum jam 10 pagi ya."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 12px; margin-top: 10px;">
                        <i class="fa-solid fa-paper-plane"></i> Posting ke Campus Feed
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Upload Bukti Selesai (Runner) -->
    <div class="modal" id="proofModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa-solid fa-camera" style="color: var(--primary);"></i> Unggah Bukti Selesai</h3>
                <button class="modal-close" onclick="closeModal('proofModal')">&times;</button>
            </div>
            <form id="proofForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div style="background: #eff6ff; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                        <div style="font-weight: 700; color: #1e40af; font-size: 0.85rem;" id="proofTaskTitle">Judul Tugas</div>
                    </div>

                    <div class="form-group">
                        <label>Catatan Pengerjaan / Lokasi Serah Terima</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Sudah ditaruh di atas meja ketua kelas / sudah diserahkan langsung."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Foto Bukti (Nota / Hasil Cetak / Serah Terima)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small style="color: #64748b; font-size: 0.75rem;">(Opsional) Foto membantu Requester memverifikasi tugasmu.</small>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 12px;">
                        <i class="fa-solid fa-check"></i> Kirim Bukti ke Requester
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 3: Konfirmasi Terima & Lepas Tip (Requester) -->
    <div class="modal" id="completeModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa-solid fa-hand-holding-dollar" style="color: var(--emerald);"></i> Konfirmasi Selesai & Beri Tip</h3>
                <button class="modal-close" onclick="closeModal('completeModal')">&times;</button>
            </div>
            <form id="completeForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div style="background: #ecfdf5; border: 1px solid #a7f3d0; padding: 14px; border-radius: 8px; margin-bottom: 16px;">
                        <div style="font-size: 0.85rem; color: #065f46;" id="completeTaskTitle">Judul Tugas</div>
                        <div style="font-size: 1.3rem; font-weight: 800; color: #059669; margin-top: 4px;" id="completeTipVal">Rp 0</div>
                        <div style="font-size: 0.75rem; color: #047857;" id="completeRunnerName">Tip akan langsung ditransfer ke dompet Runner</div>
                    </div>

                    <div class="form-group">
                        <label>Rating untuk Runner</label>
                        <select name="rating" class="form-control" required>
                            <option value="5">★★★★★ (5/5) Sangat Cepat & Memuaskan</option>
                            <option value="4">★★★★☆ (4/5) Bagus & Tepat Waktu</option>
                            <option value="3">★★★☆☆ (3/5) Cukup Baik</option>
                            <option value="2">★★☆☆☆ (2/5) Kurang Memuaskan</option>
                            <option value="1">★☆☆☆☆ (1/5) Buruk</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Ulasan / Komentar</label>
                        <textarea name="comment" class="form-control" rows="2" placeholder="Contoh: Cepat banget, tugas praktikum aman sebelum dosen masuk!"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success" style="width: 100%; justify-content: center; padding: 12px;">
                        <i class="fa-solid fa-lock"></i> Konfirmasi & Cairkan Tip
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 4: Dompet Mahasiswa -->
    <div class="modal" id="walletModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa-solid fa-wallet" style="color: var(--emerald);"></i> Dompet Mahasiswa</h3>
                <button class="modal-close" onclick="closeModal('walletModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 12px; margin-bottom: 20px;">
                    <div style="font-size: 0.85rem; color: #64748b; font-weight: 600;">Saldo Uang Saku Saat Ini</div>
                    <div style="font-size: 2rem; font-weight: 800; color: #059669;">Rp {{ number_format($currentUser->wallet_balance, 0, ',', '.') }}</div>
                    <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 4px;">Akun: {{ $currentUser->name }} ({{ $currentUser->nim }})</div>
                </div>

                <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 12px;">Riwayat Mutasi Saldo:</h4>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @forelse ($walletHistory as $history)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem;">
                            <div>
                                <div style="font-weight: 700; color: #1e293b;">{{ $history->description }}</div>
                                <div style="font-size: 0.7rem; color: #94a3b8;">{{ $history->created_at->diffForHumans() }}</div>
                            </div>
                            <div style="font-weight: 800; color: #059669;">
                                + Rp {{ number_format($history->amount, 0, ',', '.') }}
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; color: #94a3b8; font-size: 0.85rem; padding: 20px;">
                            Belum ada riwayat transaksi dompet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Interactivity -->
    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        function openProofModal(taskId, title) {
            document.getElementById('proofTaskTitle').innerText = title;
            document.getElementById('proofForm').action = '/tasks/' + taskId + '/proof';
            openModal('proofModal');
        }

        function openCompleteModal(taskId, title, tipAmount, runnerName) {
            document.getElementById('completeTaskTitle').innerText = title;
            document.getElementById('completeTipVal').innerText = 'Rp ' + Number(tipAmount).toLocaleString('id-ID');
            document.getElementById('completeRunnerName').innerText = 'Tip akan langsung ditransfer ke dompet ' + runnerName;
            document.getElementById('completeForm').action = '/tasks/' + taskId + '/complete';
            openModal('completeModal');
        }

        window.onclick = function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('active');
            }
        }
    </script>
</body>
</html>
