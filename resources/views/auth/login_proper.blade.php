@extends('layouts.jasakita')

@section('title', 'Masuk ke Akun - JasaKita')

@section('content')
<div class="auth-wrap" style="max-width: 440px; margin: 2rem auto;">
    <div class="card auth-card" style="padding: 2.25rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 16px; box-shadow: var(--shadow-md);">
        
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="width: 48px; height: 48px; background: var(--primary-light); color: var(--primary); border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.4rem; margin-bottom: 0.75rem;">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.35rem;">Masuk ke JasaKita</h2>
            <p style="color: var(--text-muted); font-size: 0.875rem;">Gunakan email dan kata sandi Anda untuk melanjutkan.</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 1.25rem;">
                <label for="login-email" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">
                    Alamat Email
                </label>
                <div style="position: relative;">
                    <i class="fa-regular fa-envelope" style="position: absolute; left: 14px; top: 13px; color: var(--text-muted);"></i>
                    <input type="email" id="login-email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                        style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.6rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'"
                        placeholder="nama@mahasiswa.ac.id">
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label for="login-sandi" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">
                    Kata Sandi
                </label>
                <div style="position: relative;">
                    <i class="fa-solid fa-key" style="position: absolute; left: 14px; top: 13px; color: var(--text-muted);"></i>
                    <input type="password" id="login-sandi" name="kata_sandi" required autocomplete="current-password" 
                        style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.6rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'"
                        placeholder="••••••••">
                    <button type="button" onclick="togglePwd('login-sandi', this)" aria-label="Tampilkan kata sandi" style="position: absolute; right: 4px; top: 50%; transform: translateY(-50%); width: 40px; height: 40px; border: none; background: none; color: var(--text-muted); cursor: pointer;">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.85rem;">
                <label style="display: flex; align-items: center; gap: 8px; color: var(--text-secondary); cursor: pointer; min-height: 44px;">
                    <input type="checkbox" name="remember" checked style="accent-color: var(--primary);"> Ingat sesi saya
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.85rem; font-size: 0.95rem;">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk Sekarang
            </button>
        </form>

        <div style="margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px solid var(--border); text-align: center; font-size: 0.85rem; color: var(--text-muted);">
            Belum memiliki akun? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 700; text-decoration: none;">Daftar Akun Baru</a>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    @media (max-width: 540px) {
        .auth-wrap { margin: 0.5rem auto !important; }
        .auth-card { padding: 1.5rem 1.15rem !important; }
    }
</style>
@endsection

@section('scripts')
<script>
    function togglePwd(id, btn) {
        const el = document.getElementById(id);
        const show = el.type === 'password';
        el.type = show ? 'text' : 'password';
        btn.innerHTML = show ? '<i class="fa-regular fa-eye-slash"></i>' : '<i class="fa-regular fa-eye"></i>';
        btn.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    }
</script>
@endsection
