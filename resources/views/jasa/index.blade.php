@extends('layouts.jasakita')

@section('title', 'Katalog Layanan Jasa Kampus - JasaKita')

@section('styles')
<style>
    .hero-banner {
        background: linear-gradient(135deg, #1E40AF 0%, #2563EB 50%, #3B82F6 100%);
        border-radius: 20px;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: var(--shadow-md);
    }

    .hero-title {
        font-size: 2.1rem;
        font-weight: 800;
        line-height: 1.25;
        margin-bottom: 0.75rem;
        letter-spacing: -0.5px;
    }

    .hero-search-box {
        display: flex;
        gap: 8px;
        background: #FFFFFF;
        padding: 6px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .category-pills {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }
    .category-pills::-webkit-scrollbar {
        display: none;
    }

    .jasa-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2.5rem;
    }

    @media (max-width: 640px) {
        .hero-banner {
            padding: 1.75rem 1.25rem;
            border-radius: 16px;
        }
        .hero-title {
            font-size: 1.5rem;
        }
        .hero-search-box {
            flex-direction: column;
            background: transparent;
            box-shadow: none;
            padding: 0;
            gap: 10px;
        }
        .hero-search-input-wrap {
            background: #FFFFFF;
            border-radius: 10px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .jasa-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Banner Kampus -->
<div class="hero-banner">
    <div style="max-width: 640px;">
        <span style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px); color: #FFFFFF; padding: 4px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 0.75rem;">
            <i class="fa-solid fa-graduation-cap"></i> Layanan Khusus Area Kampus
        </span>
        <h1 class="hero-title">
            Solusi Kebutuhan Harian & Akademik Mahasiswa
        </h1>
        <p style="color: #DBEAFE; font-size: 0.95rem; line-height: 1.55; margin-bottom: 1.5rem;">
            Pesan jasa print kilat skripsi, titip beli makan kantin kampus, servis & software laptop kuliah, hingga bantuan desain tugas dengan aman dan cepat.
        </p>

        <!-- Search Form Responsive -->
        <form action="{{ route('jasa.index') }}" method="GET" class="hero-search-box">
            <div class="hero-search-input-wrap" style="flex: 1; display: flex; align-items: center; background: white; border-radius: 8px;">
                <div style="padding-left: 12px; color: var(--text-muted);">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" name="q" aria-label="Cari layanan" value="{{ request('q') }}" placeholder="Cari jasa kampus (misal: print, makan, laptop)..." 
                    style="width: 100%; border: none; padding: 0.75rem 0.5rem; color: var(--text-main); font-size: 0.9rem; outline: none; background: transparent;">
            </div>
            @if(request('kategori_id'))
                <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
            @endif
            <button type="submit" class="btn btn-primary" style="border-radius: 8px; padding: 0.75rem 1.25rem;">
                Cari Jasa
            </button>
        </form>
    </div>
</div>

<!-- Category Pills Filter -->
<div class="category-pills">
    <a href="{{ route('jasa.index') }}" 
       class="btn {{ !request('kategori_id') ? 'btn-primary' : 'btn-outline' }}" 
       style="border-radius: 999px; font-size: 0.8rem; padding: 0.45rem 1rem; white-space: nowrap;">
       <i class="fa-solid fa-border-all"></i> Semua ({{ $jasaList->total() }})
    </a>
    @foreach($kategoriList as $kat)
        <a href="{{ route('jasa.index', ['kategori_id' => $kat->id, 'q' => request('q')]) }}" 
           class="btn {{ request('kategori_id') == $kat->id ? 'btn-primary' : 'btn-outline' }}" 
           style="border-radius: 999px; font-size: 0.8rem; padding: 0.45rem 1rem; white-space: nowrap;">
           <i class="fa-solid fa-{{ $kat->ikon ?: 'tag' }}"></i> {{ $kat->nama }} ({{ $kat->jasa_count }})
        </a>
    @endforeach
</div>

<!-- Section Header -->
<div style="background: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
    <div style="display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-lightbulb" style="color: var(--primary); font-size: 1.25rem;"></i>
        <div>
            <div style="font-weight: 700; color: var(--text-main); font-size: 0.875rem;">Butuh Titipan Kustom yang Tidak Ada di Katalog?</div>
            <div style="font-size: 0.775rem; color: var(--text-secondary);">Kamu bisa posting orderan bebas di Live Pool ala Lalamove dan tentukan tawaran ongkosmu sendiri!</div>
        </div>
    </div>
    <a href="{{ route('home') }}#buat-order" class="btn btn-primary btn-sm" style="font-weight: 700;">
        <i class="fa-solid fa-bolt"></i> Buka Live Pool
    </a>
</div>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 8px;">
    <div>
        <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-main);">Standar Tarif & Layanan Kampus</h2>
        <p style="font-size: 0.8rem; color: var(--text-muted);">Pilih layanan terpercaya yang siap dikerjakan oleh rekan mahasiswa & mitra kampus.</p>
    </div>

    @auth
        @if(Auth::user()->isPenyedia() || Auth::user()->isAdmin())
            <a href="{{ route('jasa.create') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus-circle"></i> Tambah Layanan
            </a>
        @endif
    @endauth
</div>

<!-- Grid Cards Jasa Responsive -->
<div class="jasa-grid">
    @forelse($jasaList as $item)
        <div class="card" style="display: flex; flex-direction: column; overflow: hidden; padding: 0; background: #FFFFFF; border: 1px solid var(--border);">
            <!-- Card Header Icon & Category Badge -->
            <div style="height: 130px; background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%); display: flex; align-items: center; justify-content: center; position: relative;">
                <i class="fa-solid fa-{{ $item->kategori->ikon ?: 'toolbox' }}" style="font-size: 2.75rem; color: #3B82F6; opacity: 0.85;"></i>
                <span style="position: absolute; top: 10px; left: 10px; background: #FFFFFF; color: var(--primary); font-size: 0.7rem; font-weight: 700; padding: 3px 9px; border-radius: 999px; box-shadow: var(--shadow-sm); border: 1px solid var(--border);">
                    <i class="fa-solid fa-tag"></i> {{ $item->kategori->nama ?? 'Umum' }}
                </span>
                <span style="position: absolute; top: 10px; right: 10px; background: var(--accent-light); color: var(--accent); border: 1px solid #A7F3D0; font-size: 0.65rem; font-weight: 800; padding: 2px 7px; border-radius: 5px;">
                    {{ strtoupper($item->status) }}
                </span>
            </div>

            <!-- Card Body -->
            <div style="padding: 1.15rem; flex: 1; display: flex; flex-direction: column;">
                <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.4rem; line-height: 1.35;">
                    <a href="{{ route('jasa.show', $item->id) }}" style="color: inherit; text-decoration: none;">
                        {{ $item->nama }}
                    </a>
                </h3>

                <p style="color: var(--text-muted); font-size: 0.825rem; line-height: 1.5; margin-bottom: 0.9rem; flex: 1;">
                    {{ Str::limit($item->deskripsi, 80) }}
                </p>

                <!-- Provider & Rating Info -->
                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 0.65rem; border-top: 1px solid var(--border); margin-bottom: 0.9rem; font-size: 0.8rem;">
                    <div style="display: flex; align-items: center; gap: 7px;">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700;">
                            {{ strtoupper(substr($item->penyedia->nama ?? 'P', 0, 1)) }}
                        </div>
                        <span style="color: var(--text-secondary); font-weight: 600; font-size: 0.8rem;">
                            {{ Str::limit($item->penyedia->nama ?? 'Mitra Kampus', 18) }}
                        </span>
                    </div>
                    <div style="color: #D97706; font-weight: 700; font-size: 0.8rem;">
                        <i class="fa-solid fa-star"></i> {{ number_format($item->penyedia->rating ?? 5.0, 1) }}
                    </div>
                </div>

                <!-- Price & Action -->
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase;">Tarif:</div>
                        <div style="font-size: 1.15rem; font-weight: 800; color: var(--primary);">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </div>
                    </div>
                    <a href="{{ route('jasa.show', $item->id) }}" class="btn btn-primary btn-sm">
                        Pesan <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 1rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 16px;">
            <i class="fa-solid fa-magnifying-glass" style="font-size: 2.25rem; color: var(--text-muted); margin-bottom: 0.75rem;"></i>
            <h3 style="font-size: 1.1rem; color: var(--text-main); margin-bottom: 0.35rem;">Tidak Ada Layanan yang Ditemukan</h3>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.25rem;">Coba kata kunci lain atau pilih kategori yang berbeda.</p>
            <a href="{{ route('jasa.index') }}" class="btn btn-outline btn-sm">Lihat Semua Jasa</a>
        </div>
    @endforelse
</div>

<div style="margin-top: 1rem;">
    {{ $jasaList->withQueryString()->links() }}
</div>
@endsection
