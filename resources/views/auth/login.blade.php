<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jasa Kita Kampus P2P</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-page">

    <div class="auth-container">
        <!-- Kolom Kiri: Branding & Informasi -->
        <div class="auth-hero">
            <div class="hero-brand">
                <div class="logo-icon">
                    <i class="fa-solid fa-person-running"></i>
                </div>
                <div>
                    <h2>Jasa Kita</h2>
                    <span>Kampus P2P Network</span>
                </div>
            </div>

            <div class="hero-body">
                <h1>Lagi Mepet di Kelas? Titip Teman Saja!</h1>
                <p>Platform peer-to-peer mahasiswa untuk titip print tugas, beli konsumsi kantin, atau ambil barang tertinggal dengan aman.</p>

                <div class="hero-features">
                    <div class="feature-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Cetak modul & tugas lab kilat tanpa antre</span>
                    </div>
                    <div class="feature-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Titip makanan & minuman dari kantin seberang</span>
                    </div>
                    <div class="feature-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Runner dapat tambahan tip uang saku harian</span>
                    </div>
                </div>
            </div>

            <div class="hero-footer">
                &copy; {{ date('Y') }} Jasa Kita &bull; Komunitas Kampus Terpercaya
            </div>
        </div>

        <!-- Kolom Kanan: Form Login -->
        <div class="auth-form-card">
            <div class="form-header">
                <h3>Masuk ke Akun</h3>
                <p>Gunakan Email Kampus atau Nomor Induk Mahasiswa (NIM)</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="login">Email atau NIM Mahasiswa</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-id-badge"></i>
                        <input type="text" id="login" name="login" class="form-control" 
                               placeholder="Contoh: sendy@kampus.ac.id atau 22010101" 
                               value="{{ old('login') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control" 
                               placeholder="Masukkan password Anda" required>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; font-size: 0.85rem;">
                    <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; color: #64748b; font-weight: 500;">
                        <input type="checkbox" name="remember" value="1"> Ingat Saya
                    </label>
                    <span style="color: #94a3b8; font-size: 0.75rem;">Default: password123</span>
                </div>

                <button type="submit" class="btn btn-auth-submit">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk Sekarang
                </button>
            </form>

            <!-- Quick Demo Login Section (Sangat berguna saat pengujian / demo dosen) -->
            @if(isset($demoUsers) && $demoUsers->isNotEmpty())
                <div class="demo-accounts-box">
                    <div class="demo-title">
                        <i class="fa-solid fa-bolt" style="color: #f59e0b;"></i> Klik Akun Demo (1-Klik Masuk Langsung)
                    </div>
                    <div class="demo-pills">
                        @foreach ($demoUsers as $user)
                            <form action="{{ route('login.quick', $user->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="demo-pill-btn" title="Klik untuk login sebagai {{ $user->name }}">
                                    <div class="demo-avatar">{{ substr($user->name, 0, 1) }}</div>
                                    <div class="demo-info">
                                        <div class="demo-name">{{ $user->name }}</div>
                                        <div class="demo-nim">NIM: {{ $user->nim }}</div>
                                    </div>
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

</body>
</html>
