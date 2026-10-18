<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jasa Kita - Campus P2P Micro-Errands & Jastip Mahasiswa')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tasks.css') }}">
    @stack('styles')
</head>
<body>

    @auth
        <!-- Simulation Bar (Switch Mahasiswa untuk Demo / Presentasi) -->
        <div class="simulation-bar">
            <div class="container simulation-wrapper">
                <div>
                    <i class="fa-solid fa-graduation-cap"></i> <strong>Jasa Kita</strong> &bull; Lingkungan Kampus
                </div>
                @if(isset($allUsers))
                    <form action="{{ route('tasks.switch_user') }}" method="POST" class="user-switcher">
                        @csrf
                        <span>Simulasi Akun:</span>
                        <select name="user_id" onchange="this.form.submit()">
                            @foreach ($allUsers as $u)
                                <option value="{{ $u->id }}" {{ Auth::id() === $u->id ? 'selected' : '' }}>
                                    {{ $u->name }} (NIM: {{ $u->nim }})
                                </option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>
        </div>

        <!-- Main Sticky Navbar -->
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

                <!-- Navigation Links -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <a href="{{ route('tasks.index') }}" class="pill-btn {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-list-check"></i> Campus Feed
                    </a>
                    <a href="{{ route('products.index') }}" class="pill-btn {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-boxes-stacked"></i> Master Produk <span style="background: #f59e0b; color: #fff; font-size: 0.65rem; padding: 2px 6px; border-radius: 4px; font-weight: 800; margin-left: 4px;">Modul 6</span>
                    </a>
                </div>

                <div class="nav-actions">
                    <!-- Dompet Pill -->
                    <div class="wallet-pill" onclick="openModal('walletModal')" title="Buka Riwayat Dompet">
                        <i class="fa-solid fa-wallet"></i>
                        <span>Rp {{ number_format(Auth::user()->wallet_balance, 0, ',', '.') }}</span>
                    </div>

                    <!-- User Info & Logout -->
                    <div class="user-profile-badge">
                        <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                        <span>{{ Auth::user()->name }}</span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger" title="Keluar / Logout">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </form>

                    <!-- Tombol Buat Tugas -->
                    <button class="btn btn-primary" onclick="openModal('createTaskModal')">
                        <i class="fa-solid fa-plus-circle"></i> Titip Tugas
                    </button>
                </div>
            </div>
        </nav>
    @endauth

    <!-- Flash Alerts Container -->
    <div class="container" style="margin-top: 20px;">
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <ul style="margin-left: 20px; list-style-type: disc;">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    @yield('content')

    <!-- Modals -->
    @stack('modals')

    <!-- Global Modal JavaScript -->
    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.classList.add('active');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.classList.remove('active');
        }

        window.onclick = function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('active');
            }
        };

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
                    formElement.submit();
                }
            });
            return false;
        }

        // SweetAlert2 Flash Message Handlers
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#2563EB',
                    confirmButtonText: 'OK',
                    timer: 3500,
                    timerProgressBar: true
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Perhatian',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#2563EB',
                    confirmButtonText: 'Mengerti'
                });
            @endif

            @if(isset($errors) && $errors->any())
                let errorHtml = '<div style="text-align: left; padding: 4px 8px;"><ul style="margin: 0; padding-left: 20px; font-size: 0.85rem; color: #E11D48; line-height: 1.6;">';
                @foreach ($errors->all() as $err)
                    errorHtml += '<li>{{ $err }}</li>';
                @endforeach
                errorHtml += '</ul></div>';

                Swal.fire({
                    icon: 'warning',
                    title: 'Mohon Periksa Data Anda',
                    html: errorHtml,
                    confirmButtonColor: '#2563EB',
                    confirmButtonText: 'Perbaiki'
                });
            @endif
        });
    </script>
    @stack('scripts')
</body>
</html>
