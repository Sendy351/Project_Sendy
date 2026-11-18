@extends('layouts.jasakita')

@section('title', $jasa->nama . ' - JasaKita')

@section('styles')
<style>
    .detail-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.75rem;
        align-items: start;
    }

    .meta-highlights {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        background: var(--bg-page);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.75rem;
    }

    .booking-sidebar {
        position: sticky;
        top: 85px;
    }

    @media (max-width: 868px) {
        .detail-layout {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
        .booking-sidebar {
            position: static;
        }
    }

    @media (max-width: 540px) {
        .meta-highlights {
            grid-template-columns: 1fr;
            gap: 0.75rem;
            padding: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 1.25rem;">
    <a href="{{ route('jasa.index') }}" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog Layanan
    </a>
</div>

<div class="detail-layout">
    
    <!-- Left Column: Details & Reviews -->
    <div>
        <div class="card" style="padding: 1.75rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 16px; margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 10px;">
                <div>
                    <span style="background: var(--primary-light); color: var(--primary); font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 999px;">
                        <i class="fa-solid fa-tag"></i> {{ $jasa->kategori->nama ?? 'Umum' }}
                    </span>
                    <h1 style="font-size: 1.6rem; font-weight: 800; color: var(--text-main); margin-top: 0.6rem; line-height: 1.3;">
                        {{ $jasa->nama }}
                    </h1>
                </div>

                @auth
                    @if(Auth::user()->isAdmin() || (Auth::user()->isPenyedia() && Auth::user()->penyediaJasa?->id == $jasa->penyedia_id))
                        <div style="display: flex; gap: 6px;">
                            <a href="{{ route('jasa.edit', $jasa->id) }}" class="btn btn-outline btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form action="{{ route('jasa.destroy', $jasa->id) }}" method="POST" onsubmit="return confirmSwal(this, { title: 'Hapus Layanan Jasa Ini?', text: 'Data layanan jasa ini akan dihapus secara permanen dari katalog.', icon: 'warning', confirmButtonText: 'Ya, Hapus Layanan', confirmButtonColor: '#E11D48' });">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-sm" style="color: var(--rose); border-color: #FECDD3;">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Price & Meta Highlights Responsive -->
            <div class="meta-highlights">
                <div>
                    <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase;">Tarif Layanan:</div>
                    <div style="font-size: 1.35rem; font-weight: 800; color: var(--primary); margin-top: 2px;">
                        Rp {{ number_format($jasa->harga, 0, ',', '.') }}
                    </div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase;">Estimasi Waktu:</div>
                    <div style="font-size: 1rem; font-weight: 700; color: var(--text-main); margin-top: 2px;">
                        <i class="fa-regular fa-clock" style="color: var(--primary);"></i> {{ $jasa->durasi }}
                    </div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase;">Ketersediaan:</div>
                    <div style="font-size: 1rem; font-weight: 700; color: var(--accent); margin-top: 2px;">
                        <i class="fa-solid fa-circle-check"></i> Siap Dipesan
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 1.75rem;">
                <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem;">Deskripsi & Informasi Layanan</h3>
                <div style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.6; white-space: pre-line;">
                    {{ $jasa->deskripsi ?: 'Tidak ada deskripsi rinci untuk layanan ini.' }}
                </div>
            </div>

            <!-- Provider Box -->
            <div style="background: var(--primary-light); border: 1px solid #BFDBFE; border-radius: 12px; padding: 1.25rem;">
                <div style="font-size: 0.7rem; font-weight: 800; color: var(--primary); text-transform: uppercase; margin-bottom: 0.6rem;">Mitra Penyedia Jasa Kampus:</div>
                <div style="display: flex; gap: 0.85rem; align-items: flex-start;">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: white; font-weight: 800; flex-shrink: 0;">
                        {{ strtoupper(substr($jasa->penyedia->nama ?? 'P', 0, 1)) }}
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 6px;">
                            <h4 style="font-size: 1rem; font-weight: 800; color: var(--text-main);">{{ $jasa->penyedia->nama ?? 'Penyedia Jasa' }}</h4>
                            <div style="background: var(--amber-light); color: var(--amber); border: 1px solid #FDE68A; padding: 2px 8px; border-radius: 999px; font-weight: 800; font-size: 0.8rem;">
                                <i class="fa-solid fa-star"></i> {{ number_format($jasa->penyedia->rating ?? 5.0, 1) }}
                            </div>
                        </div>
                        <p style="color: var(--text-muted); font-size: 0.8rem; margin: 3px 0 6px;">
                            <i class="fa-solid fa-location-dot" style="color: var(--rose);"></i> {{ $jasa->penyedia->alamat ?? 'Area Kampus' }} • 
                            <i class="fa-solid fa-phone" style="color: var(--accent);"></i> {{ $jasa->penyedia->telepon ?? '-' }}
                        </p>
                        <p style="color: var(--text-secondary); font-size: 0.825rem; line-height: 1.45;">
                            {{ $jasa->penyedia->deskripsi ?? 'Mitra mahasiswa terpercaya di lingkungan kampus.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ulasan Section -->
        <div class="card" style="padding: 1.5rem; background: #FFFFFF; border: 1px solid var(--border);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--text-main);">
                    <i class="fa-solid fa-comments" style="color: var(--primary);"></i> Ulasan Mahasiswa
                </h3>
                <span style="font-size: 0.8rem; color: var(--text-muted);">{{ $jasa->penyedia->ulasan->count() }} Ulasan</span>
            </div>

            @forelse($jasa->penyedia->ulasan as $review)
                <div style="padding: 0.85rem 0; border-bottom: 1px solid var(--border);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                        <span style="font-weight: 700; color: var(--text-main); font-size: 0.85rem;">
                            {{ $review->pengguna->nama ?? 'Mahasiswa' }}
                        </span>
                        <span style="color: var(--amber); font-size: 0.8rem;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                            @endfor
                        </span>
                    </div>
                    <p style="color: var(--text-secondary); font-size: 0.825rem; line-height: 1.45;">
                        "{{ $review->komentar }}"
                    </p>
                    <div style="font-size: 0.725rem; color: var(--text-muted); margin-top: 3px;">
                        {{ $review->dibuat_pada ? date('d M Y, H:i', strtotime($review->dibuat_pada)) : '-' }}
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 1.5rem; color: var(--text-muted); font-size: 0.825rem;">
                    Belum ada ulasan untuk penyedia ini. Jadilah yang pertama memesan!
                </div>
            @endforelse
        </div>
    </div>

    <!-- Right Column: Booking Order Form Responsive -->
    <div>
        <div class="card booking-sidebar" style="padding: 1.5rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 16px; box-shadow: var(--shadow-md);">
            <div style="margin-bottom: 1.25rem;">
                <span style="background: var(--primary-light); color: var(--primary); font-size: 0.7rem; font-weight: 800; padding: 2px 7px; border-radius: 5px;">
                    FORM PEMESANAN
                </span>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--text-main); margin-top: 6px;">Pesan Layanan</h3>
                <p style="font-size: 0.775rem; color: var(--text-muted);">Tentukan jadwal dan lokasi pengerjaan di area kampus.</p>
            </div>

            @auth
                <form action="{{ route('pesanan.booking') }}" method="POST">
                    @csrf
                    <input type="hidden" name="jasa_id" value="{{ $jasa->id }}">

                    <div style="margin-bottom: 0.9rem;">
                        <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px;">
                            Titik Lokasi (Gedung/Fakultas/Kost)
                        </label>
                        <textarea name="lokasi" aria-label="Lokasi" required rows="2" 
                            style="width: 100%; padding: 0.65rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 8px; color: var(--text-main); font-size: 0.825rem; outline: none;"
                            placeholder="Contoh: Gedung B Lt. 2 Ruang 204 atau Kost Asri Blok B...">{{ Auth::user()->alamat }}</textarea>
                    </div>

                    <div style="margin-bottom: 0.9rem;">
                        <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px;">
                            Waktu Kedatangan / Penjemputan
                        </label>
                        <input type="datetime-local" name="jadwal" aria-label="Jadwal" required 
                            value="{{ now()->addHours(2)->format('Y-m-d\TH:i') }}"
                            style="width: 100%; padding: 0.65rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 8px; color: var(--text-main); font-size: 0.825rem; outline: none;">
                    </div>

                    <div style="margin-bottom: 1.25rem;">
                        <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px;">
                            Rincian / Catatan Tambahan
                        </label>
                        <textarea name="deskripsi" aria-label="Deskripsi" rows="2" 
                            style="width: 100%; padding: 0.65rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 8px; color: var(--text-main); font-size: 0.825rem; outline: none;"
                            placeholder="Contoh: Dokumen sudah siap cetak, jilid warna biru..."></textarea>
                    </div>

                    <div style="padding: 0.85rem; background: var(--bg-page); border-radius: 8px; margin-bottom: 1.25rem; border: 1px solid var(--border);">
                        <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 4px;">
                            <span>Tarif Layanan:</span>
                            <span style="color: var(--text-main); font-weight: 700;">Rp {{ number_format($jasa->harga, 0, ',', '.') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 6px;">
                            <span>Biaya Layanan Kampus:</span>
                            <span style="color: var(--accent); font-weight: 700;">GRATIS</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 1rem; color: var(--text-main); font-weight: 800; border-top: 1px dashed var(--border); padding-top: 6px;">
                            <span>Total Pembayaran:</span>
                            <span style="color: var(--primary);">Rp {{ number_format($jasa->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.9rem;">
                        <i class="fa-solid fa-paper-plane"></i> Konfirmasi Pemesanan
                    </button>
                </form>
            @else
                <div style="text-align: center; padding: 1rem 0;">
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1rem;">
                        Silakan masuk ke akun Anda untuk memesan layanan ini.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">
                        <i class="fa-solid fa-right-to-bracket"></i> Masuk Sekarang
                    </a>
                </div>
            @endauth
        </div>
    </div>

</div>
@endsection
