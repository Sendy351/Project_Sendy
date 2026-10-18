@extends('layouts.jasakita')

@section('title', 'Masuk ke Akun - JasaKita')

@section('content')
<div style="max-width: 440px; margin: 2rem auto;">
    <div class="card" style="padding: 2.25rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 16px; box-shadow: var(--shadow-md);">
        
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
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">
                    Alamat Email
                </label>
                <div style="position: relative;">
                    <i class="fa-regular fa-envelope" style="position: absolute; left: 14px; top: 13px; color: var(--text-muted);"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.6rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'"
                        placeholder="nama@mahasiswa.ac.id">
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">
                    Kata Sandi
                </label>
                <div style="position: relative;">
                    <i class="fa-solid fa-key" style="position: absolute; left: 14px; top: 13px; color: var(--text-muted);"></i>
                    <input type="password" name="kata_sandi" required 
                        style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.6rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'"
                        placeholder="••••••••">
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.85rem;">
                <label style="display: flex; align-items: center; gap: 8px; color: var(--text-secondary); cursor: pointer;">
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
