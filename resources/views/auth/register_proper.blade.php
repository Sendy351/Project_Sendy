@extends('layouts.jasakita')

@section('title', 'Daftar Akun Baru - JasaKita')

@section('content')
<div style="max-width: 580px; margin: 1.5rem auto;">
    <div class="card" style="padding: 2.25rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 16px; box-shadow: var(--shadow-md);">
        
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="width: 48px; height: 48px; background: var(--primary-light); color: var(--primary); border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.4rem; margin-bottom: 0.75rem;">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.35rem;">Pendaftaran Akun Baru</h2>
            <p style="color: var(--text-muted); font-size: 0.875rem;">Bergabunglah dengan komunitas layanan jasa di lingkungan kampus.</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 8px;">
                    Daftar Sebagai:
                </label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <label style="background: var(--bg-page); border: 2px solid var(--border); border-radius: 10px; padding: 12px; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.2s;"
                           onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                        <input type="radio" name="peran" value="pelanggan" checked style="accent-color: var(--primary);">
                        <div>
                            <div style="font-weight: 700; font-size: 0.9rem; color: var(--text-main);">Pelanggan / Mahasiswa</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Pesan kebutuhan jasa</div>
                        </div>
                    </label>

                    <label style="background: var(--bg-page); border: 2px solid var(--border); border-radius: 10px; padding: 12px; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.2s;"
                           onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                        <input type="radio" name="peran" value="penyedia" style="accent-color: var(--primary);">
                        <div>
                            <div style="font-weight: 700; font-size: 0.9rem; color: var(--text-main);">Penyedia Jasa</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Buka layanan di kampus</div>
                        </div>
                    </label>
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Muhammad Ilham"
                    style="width: 100%; padding: 0.75rem 1rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 1.25rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="ilham@mahasiswa.ac.id"
                        style="width: 100%; padding: 0.75rem 1rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="telepon" value="{{ old('telepon') }}" placeholder="081234567890"
                        style="width: 100%; padding: 0.75rem 1rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Lokasi / Alamat Kost Sekitar Kampus</label>
                <textarea name="alamat" rows="2" placeholder="Kost Asri No. 12, Jl. Ring Road Kampus..."
                    style="width: 100%; padding: 0.75rem 1rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none;">{{ old('alamat') }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 1.75rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Kata Sandi</label>
                    <input type="password" name="kata_sandi" required placeholder="Minimal 6 karakter"
                        style="width: 100%; padding: 0.75rem 1rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Konfirmasi Sandi</label>
                    <input type="password" name="kata_sandi_confirmation" required placeholder="Ulangi sandi"
                        style="width: 100%; padding: 0.75rem 1rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none;">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.85rem; font-size: 0.95rem;">
                <i class="fa-solid fa-user-check"></i> Daftar Sekarang
            </button>
        </form>

        <div style="margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px solid var(--border); text-align: center; font-size: 0.85rem; color: var(--text-muted);">
            Sudah memiliki akun? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700; text-decoration: none;">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection
