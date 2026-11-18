@extends('layouts.jasakita')

@section('title', 'Live Pool Orderan Kampus - JasaKita')

@section('styles')
<style>
    /* Hero On-Demand Pool */
    .pool-hero {
        background: linear-gradient(135deg, #1E40AF 0%, #2563EB 55%, #3B82F6 100%);
        border-radius: 20px;
        padding: 2.25rem 2rem;
        margin-bottom: 1.5rem;
        color: white;
        box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.25);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .pool-hero::after {
        content: '';
        position: absolute;
        right: -30px;
        top: -30px;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Live Ticker Bar */
    .live-ticker-bar {
        background: #FFFFFF;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 0.65rem 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: var(--shadow-sm);
        font-size: 0.825rem;
    }

    .ticker-badge {
        background: #EFF6FF;
        color: var(--primary);
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.75rem;
        white-space: nowrap;
    }

    .ticker-content {
        color: var(--text-secondary);
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        flex: 1;
    }

    /* Stats Grid */
    .pool-stats-bar {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .pool-stat-card {
        background: #FFFFFF;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: var(--shadow-sm);
        transition: transform 0.2s;
    }

    .pool-stat-card:hover {
        transform: translateY(-2px);
    }

    .pool-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /* Filter Bar */
    .filter-section {
        background: #FFFFFF;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
    }

    .category-pills {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 2px;
    }
    .category-pills::-webkit-scrollbar {
        display: none;
    }

    /* Order Card ala Lalamove */
    .order-card {
        background: #FFFFFF;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.35rem;
        margin-bottom: 1rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1.5rem;
        position: relative;
    }

    .order-card:hover {
        border-color: #93C5FD;
        box-shadow: 0 8px 20px -4px rgba(37, 99, 235, 0.08);
        transform: translateY(-2px);
    }

    /* Visual Route Step */
    .visual-route {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin: 0.85rem 0;
        background: #F8FAFC;
        padding: 0.85rem 1rem;
        border-radius: 12px;
        border: 1px solid #E2E8F0;
    }

    .route-markers {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
        padding-top: 3px;
    }

    .marker-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }
    .marker-dot.pickup { background: #10B981; }
    .marker-dot.dropoff { background: #2563EB; }

    .marker-line {
        width: 2px;
        height: 24px;
        background: #CBD5E1;
        border-style: dashed;
    }

    .route-texts {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
        font-size: 0.825rem;
    }

    .route-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .route-label {
        color: var(--text-muted);
        font-size: 0.72rem;
        text-transform: uppercase;
        font-weight: 700;
        margin-right: 6px;
    }

    .route-place {
        color: var(--text-main);
        font-weight: 600;
    }

    .quick-template-chip {
        background: #EFF6FF;
        color: var(--primary);
        border: 1px solid #BFDBFE;
        border-radius: 8px;
        padding: 6px 10px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .quick-template-chip:hover {
        background: var(--primary);
        color: white;
    }

    @media (max-width: 868px) {
        .pool-hero {
            padding: 1.5rem 1.25rem;
            border-radius: 16px;
        }
        .pool-stats-bar {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        .order-card {
            flex-direction: column;
            align-items: stretch;
            gap: 1.2rem;
        }
        .order-action-col {
            border-left: none !important;
            padding-left: 0 !important;
            border-top: 1px solid var(--border);
            padding-top: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            min-width: 0 !important;
            text-align: left !important;
        }
        .order-action-col > form,
        .order-action-col > a {
            flex-shrink: 0;
        }
        .pool-hero h1 {
            font-size: 1.45rem !important;
        }
        .pool-hero .btn {
            width: 100%;
        }
        .pool-hero > div:last-child {
            width: 100%;
        }
        /* 3 kartu statistik: di HP digeser horizontal, gak numpuk 3 baris */
        .pool-stats-bar {
            grid-template-columns: repeat(3, minmax(200px, 1fr));
            overflow-x: auto;
            scrollbar-width: none;
            padding-bottom: 2px;
        }
        .pool-stats-bar::-webkit-scrollbar { display: none; }
        .pool-stat-card { padding: 0.85rem 1rem; }
        .route-hint { display: none; }
        .live-ticker-bar .ticker-online { display: none !important; }
    }

    @media (max-width: 540px) {
        .form-grid-2 {
            grid-template-columns: 1fr !important;
        }
        /* Modal buat orderan jadi bottom-sheet di HP */
        #modal-buat-orderan {
            align-items: flex-end !important;
            padding: 0 !important;
        }
        #modal-buat-orderan > div {
            border-radius: 20px 20px 0 0 !important;
            padding: 1.25rem 1.1rem calc(1.25rem + env(safe-area-inset-bottom)) !important;
            max-height: 92vh !important;
        }
        .quick-template-chip {
            min-height: 40px;
        }
    }
</style>
@endsection

@section('content')

<!-- Hero On-Demand Pool -->
<div class="pool-hero">
    <div style="max-width: 640px; position: relative; z-index: 1;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 0.75rem;">
            <span style="background: rgba(255, 255, 255, 0.22); backdrop-filter: blur(8px); color: #FFFFFF; padding: 4px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <span class="pulse-dot"></span> On-Demand Campus Errand Feed
            </span>
            <span style="color: #DBEAFE; font-size: 0.75rem; font-weight: 600;">
                <i class="fa-solid fa-bolt"></i> 18 Runner Aktif
            </span>
        </div>
        <h1 style="font-size: 1.85rem; font-weight: 800; line-height: 1.25; margin-bottom: 0.65rem; letter-spacing: -0.5px;">
            Pool Titipan & Jasa Mahasiswa Kampus
        </h1>
        <p style="color: #DBEAFE; font-size: 0.925rem; line-height: 1.55;">
            Lagi ada di kelas, perpustakaan, atau asrama? Posting kebutuhanmu (titip makan, cetak skripsi, ambil paket). Mahasiswa lain yang searah siap mengambil orderanmu dalam hitungan menit!
        </p>
    </div>

    <div style="position: relative; z-index: 1;">
        @auth
            <button onclick="openCreateModal()" class="btn" style="background: #FFFFFF; color: var(--primary); padding: 0.85rem 1.6rem; font-size: 0.95rem; font-weight: 800; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.15); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fa-solid fa-plus-circle"></i> Buat Orderan Baru
            </button>
        @else
            <a href="{{ route('login') }}" class="btn" style="background: #FFFFFF; color: var(--primary); padding: 0.85rem 1.6rem; font-size: 0.95rem; font-weight: 800; border-radius: 12px;">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk untuk Posting
            </a>
        @endauth
    </div>
</div>

<!-- Live Activity Ticker -->
<div class="live-ticker-bar">
    <div class="ticker-badge">
        <i class="fa-solid fa-satellite-dish"></i> LIVE KAMPUS
    </div>
    <div class="ticker-content" id="liveTickerText">
        <span>🚀 <strong>Sendy (Runner)</strong> baru saja menyelesaikan titip cetak laporan di Lab Komputer • 2 menit lalu</span>
    </div>
    <div class="ticker-online" style="color: var(--text-muted); font-size: 0.75rem; display: flex; align-items: center; gap: 4px;">
        <span class="pulse-dot"></span> Online
    </div>
</div>

<!-- Stats Bar Kampus -->
<div class="pool-stats-bar">
    <div class="pool-stat-card">
        <div class="pool-stat-icon" style="background: var(--primary-light); color: var(--primary);">
            <i class="fa-solid fa-inbox"></i>
        </div>
        <div>
            <div style="font-size: 0.72rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Orderan di Pool</div>
            <div style="font-size: 1.3rem; font-weight: 800; color: var(--text-main);">{{ $openOrders->total() }} Tersedia</div>
        </div>
    </div>

    <div class="pool-stat-card">
        <div class="pool-stat-icon" style="background: var(--accent-light); color: var(--accent);">
            <i class="fa-solid fa-person-running"></i>
        </div>
        <div>
            <div style="font-size: 0.72rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Sistem Pengambilan</div>
            <div style="font-size: 1.3rem; font-weight: 800; color: var(--text-main);">Bebas Diambil (P2P)</div>
        </div>
    </div>

    <div class="pool-stat-card">
        <div class="pool-stat-icon" style="background: var(--amber-light); color: var(--amber);">
            <i class="fa-solid fa-stopwatch"></i>
        </div>
        <div>
            <div style="font-size: 0.72rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Rata-rata Waktu Tiba</div>
            <div style="font-size: 1.3rem; font-weight: 800; color: var(--text-main);">7 - 15 Menit</div>
        </div>
    </div>
</div>

<!-- Filter Bar & Search -->
<div class="filter-section">
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap;">
        <!-- Search Input Form -->
        <form action="{{ route('home') }}" method="GET" style="display: flex; gap: 8px; flex: 1 1 260px; max-width: 450px;">
            @if(request('kategori_id'))
                <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
            @endif
            <div style="position: relative; width: 100%;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.85rem;"></i>
                <input type="search" name="q" value="{{ request('q') }}" aria-label="Cari orderan" placeholder="Cari titipan, lokasi, atau gedung..." 
                    style="width: 100%; padding: 0.55rem 0.75rem 0.55rem 2.2rem; background: #F8FAFC; border: 1px solid var(--border); border-radius: 999px; font-size: 0.825rem; outline: none;">
            </div>
            <button type="submit" class="btn btn-outline btn-sm" style="border-radius: 999px;">
                Cari
            </button>
            @if(request('q') || request('kategori_id'))
                <a href="{{ route('home') }}" class="btn btn-outline btn-sm" style="border-radius: 999px;" title="Reset Filter" aria-label="Reset filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </form>

        {{-- Sebelumnya tulisan "Update Otomatis" padahal halaman gak auto-refresh. Sekarang tombol muat ulang beneran. --}}
        <a href="{{ request()->fullUrl() }}" class="btn btn-outline btn-sm" style="border-radius: 999px; font-size: 0.775rem;">
            <i class="fa-solid fa-arrows-rotate" style="color: var(--primary);"></i> Muat Ulang
        </a>
    </div>

    <!-- Category Pills -->
    <div class="category-pills">
        <a href="{{ route('home', ['q' => request('q')]) }}" 
           class="btn {{ !request('kategori_id') ? 'btn-primary' : 'btn-outline' }}" 
           style="border-radius: 999px; font-size: 0.775rem; padding: 0.4rem 0.9rem; white-space: nowrap;">
           <i class="fa-solid fa-border-all"></i> Semua Kategori ({{ $openOrders->total() }})
        </a>
        @foreach($kategoriList as $kat)
            <a href="{{ route('home', ['kategori_id' => $kat->id, 'q' => request('q')]) }}" 
               class="btn {{ request('kategori_id') == $kat->id ? 'btn-primary' : 'btn-outline' }}" 
               style="border-radius: 999px; font-size: 0.775rem; padding: 0.4rem 0.9rem; white-space: nowrap;">
               <i class="fa-solid fa-{{ $kat->ikon ?: 'tag' }}"></i> {{ $kat->nama }}
            </a>
        @endforeach
    </div>
</div>

<!-- Section Title -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
    <div>
        <h2 style="font-size: 1.15rem; font-weight: 800; color: var(--text-main);">
            Orderan Terbuka Siap Diambil
        </h2>
        <p style="font-size: 0.78rem; color: var(--text-muted);">
            Klik "Ambil Orderan" untuk mengambil tugas dan mengantarkannya ke pemesan di kampus.
        </p>
    </div>
</div>

<!-- Order Feed Cards ala Lalamove -->
<div style="margin-bottom: 2.5rem;">
    @forelse($openOrders as $order)
        <div class="order-card">
            <!-- Left: Order Details & Route -->
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; flex-wrap: wrap;">
                    <span style="background: var(--primary-light); color: var(--primary); font-size: 0.725rem; font-weight: 700; padding: 3px 9px; border-radius: 6px;">
                        <i class="fa-solid fa-{{ $order->jasa->kategori->ikon ?? 'tag' }}"></i> {{ $order->jasa->nama }}
                    </span>
                    <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.725rem; color: var(--accent); font-weight: 700; background: var(--accent-light); padding: 2px 7px; border-radius: 4px;">
                        <span class="pulse-dot"></span> Terbuka di Pool
                    </span>
                    <span style="font-size: 0.75rem; color: var(--text-muted);">
                        • Diposting {{ date('H:i', strtotime($order->dibuat_pada)) }} WIB oleh <strong>{{ $order->pengguna->nama }}</strong>
                    </span>
                </div>

                <!-- Description Title -->
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text-main); margin-bottom: 6px; line-height: 1.35;">
                    "{{ $order->deskripsi }}"
                </h3>

                <!-- Visual Route ala Lalamove -->
                @php
                    $lokasiParts = explode('-> Antar ke:', $order->lokasi);
                    $jemput = str_replace('Ambil:', '', $lokasiParts[0] ?? $order->lokasi);
                    $antar = $lokasiParts[1] ?? 'Lokasi Pemesan di Kampus';
                @endphp
                <div class="visual-route">
                    <div class="route-markers">
                        <div class="marker-dot pickup" title="Titik Jemput"></div>
                        <div class="marker-line"></div>
                        <div class="marker-dot dropoff" title="Titik Antar"></div>
                    </div>
                    <div class="route-texts">
                        <div class="route-row">
                            <div>
                                <span class="route-label">Jemput:</span>
                                <span class="route-place">{{ trim($jemput) }}</span>
                            </div>
                            <span class="route-hint" style="font-size: 0.7rem; color: var(--text-muted); white-space: nowrap;"><i class="fa-solid fa-store"></i> Titik Awal</span>
                        </div>
                        <div class="route-row">
                            <div>
                                <span class="route-label">Antar ke:</span>
                                <span class="route-place" style="color: var(--primary);">{{ trim($antar) }}</span>
                            </div>
                            <span class="route-hint" style="font-size: 0.7rem; color: var(--text-muted); white-space: nowrap;"><i class="fa-solid fa-location-dot"></i> Tujuan</span>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 14px; font-size: 0.75rem; color: var(--text-muted); flex-wrap: wrap;">
                    <span><i class="fa-regular fa-clock" style="color: var(--primary);"></i> Target Diantar: <strong>{{ date('d M, H:i', strtotime($order->jadwal)) }} WIB</strong></span>
                    <span><i class="fa-solid fa-shield-halved" style="color: var(--accent);"></i> Transaksi Terverifikasi Kampus</span>
                </div>
            </div>

            <!-- Right: Price & Claim Action -->
            <div class="order-action-col" style="border-left: 1px solid var(--border); padding-left: 1.5rem; text-align: right; min-width: 170px;">
                <div style="margin-bottom: 0.75rem;">
                    <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Ongkos Bersih Runner:</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: var(--primary); letter-spacing: -0.5px;">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </div>
                    <div style="font-size: 0.68rem; color: var(--accent); font-weight: 600;">
                        <i class="fa-solid fa-check"></i> Langsung masuk dompet/tunai
                    </div>
                </div>

                @auth
                    @if(Auth::id() === $order->pengguna_id)
                        <span style="background: var(--bg-subtle); color: var(--text-muted); font-size: 0.775rem; font-weight: 700; padding: 7px 12px; border-radius: 8px; border: 1px solid var(--border); display: inline-block;">
                            <i class="fa-solid fa-user"></i> Orderan Milik Anda
                        </span>
                    @else
                        <form action="{{ route('order.claim', $order->id) }}" method="POST" onsubmit="return confirmSwal(this, { title: 'Ambil Orderan Kampus Ini?', text: 'Anda akan ditugaskan sebagai runner untuk mengantar pesanan ke {{ addslashes(trim($antar)) }}.', icon: 'question', confirmButtonText: 'Ya, Ambil Orderan', confirmButtonColor: '#10B981' });">
                            @csrf
                            <button type="submit" class="btn btn-emerald" style="padding: 0.7rem 1.25rem; font-weight: 800; width: 100%; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);">
                                <i class="fa-solid fa-hand-holding-hand"></i> Ambil Orderan
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm" style="width: 100%;">
                        <i class="fa-solid fa-right-to-bracket"></i> Masuk untuk Ambil
                    </a>
                @endauth
            </div>
        </div>
    @empty
        @php $isFiltered = request()->filled('q') || request()->filled('kategori_id'); @endphp
        <div style="text-align: center; padding: 3rem 1.25rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 16px;">
            <div style="width: 60px; height: 60px; background: {{ $isFiltered ? 'var(--bg-subtle)' : 'var(--accent-light)' }}; color: {{ $isFiltered ? 'var(--text-muted)' : 'var(--accent)' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.6rem;">
                <i class="fa-solid fa-{{ $isFiltered ? 'magnifying-glass' : 'inbox' }}"></i>
            </div>
            @if($isFiltered)
                {{-- Sebelumnya hasil pencarian kosong tetap bilang "Semua orderan sudah diambil" (menyesatkan) --}}
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.35rem;">
                    Gak ada orderan yang cocok
                </h3>
                <p style="color: var(--text-muted); font-size: 0.85rem; max-width: 480px; margin: 0 auto 1.25rem; line-height: 1.5;">
                    Coba kata kunci lain atau hapus filter kategori.
                </p>
                <a href="{{ route('home') }}" class="btn btn-outline">
                    <i class="fa-solid fa-rotate-left"></i> Reset Pencarian
                </a>
            @else
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.35rem;">
                    Belum ada orderan di pool
                </h3>
                <p style="color: var(--text-muted); font-size: 0.85rem; max-width: 480px; margin: 0 auto 1.25rem; line-height: 1.5;">
                    Semua orderan sudah diambil runner. Mahasiswa biasanya posting saat jam makan siang atau pergantian kelas.
                </p>
                @auth
                    <button type="button" onclick="openCreateModal()" class="btn btn-primary">
                        <i class="fa-solid fa-plus-circle"></i> Buat Orderan
                    </button>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fa-solid fa-right-to-bracket"></i> Masuk untuk Posting
                    </a>
                @endauth
            @endif
        </div>
    @endforelse
</div>

<!-- Pagination -->
{{-- View pagination bawaan Laravel pakai class Tailwind yang gak di-load di layout ini (panahnya jadi raksasa). Ganti markup sederhana. --}}
@if($openOrders->hasPages())
    <nav aria-label="Navigasi halaman" style="margin-top: 1rem; margin-bottom: 1.5rem;">
        <ul class="pager">
            <li>
                @if($openOrders->onFirstPage())
                    <span aria-disabled="true"><i class="fa-solid fa-chevron-left"></i>&nbsp; Sebelumnya</span>
                @else
                    <a href="{{ $openOrders->withQueryString()->previousPageUrl() }}" rel="prev"><i class="fa-solid fa-chevron-left"></i>&nbsp; Sebelumnya</a>
                @endif
            </li>
            <li><span style="background: #FFFFFF;">{{ $openOrders->currentPage() }} / {{ $openOrders->lastPage() }}</span></li>
            <li>
                @if($openOrders->hasMorePages())
                    <a href="{{ $openOrders->withQueryString()->nextPageUrl() }}" rel="next">Berikutnya &nbsp;<i class="fa-solid fa-chevron-right"></i></a>
                @else
                    <span aria-disabled="true">Berikutnya &nbsp;<i class="fa-solid fa-chevron-right"></i></span>
                @endif
            </li>
        </ul>
    </nav>
@endif

<!-- Modal Posting Orderan Baru (Cepat, Clean, & Production-Ready) -->
<div id="modal-buat-orderan" role="dialog" aria-modal="true" aria-labelledby="judul-buat-orderan" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #FFFFFF; border: 1px solid var(--border); border-radius: 20px; width: 100%; max-width: 540px; padding: 1.75rem 2rem; box-shadow: var(--shadow-lg); max-height: 90vh; overflow-y: auto;">
        
        <!-- Modal Header -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 1.25rem;">
            <div>
                <span style="font-size: 0.725rem; font-weight: 800; color: var(--primary); text-transform: uppercase;">Posting ke Pool Kampus</span>
                <h3 id="judul-buat-orderan" style="font-size: 1.25rem; font-weight: 800; color: var(--text-main); margin-top: 2px;">Buat Orderan Baru</h3>
                <p style="font-size: 0.78rem; color: var(--text-muted);">Runner terdekat di kampus akan segera mengambil dan mengantar tugasmu.</p>
            </div>
            <button type="button" onclick="closeCreateModal()" class="modal-close" aria-label="Tutup">&times;</button>
        </div>

        <!-- Quick Shortcut Templates -->
        <div style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">
                <i class="fa-solid fa-wand-magic-sparkles" style="color: var(--amber);"></i> Contoh Cepat (Klik untuk Isi Otomatis):
            </label>
            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                <button type="button" class="quick-template-chip" onclick="applyTemplate('makan')">
                    🍔 Titip Makan Kantin
                </button>
                <button type="button" class="quick-template-chip" onclick="applyTemplate('print')">
                    📄 Cetak / Print Skripsi
                </button>
                <button type="button" class="quick-template-chip" onclick="applyTemplate('paket')">
                    📦 Ambil Paket Satpam
                </button>
                <button type="button" class="quick-template-chip" onclick="applyTemplate('kopi')">
                    ☕ Titip Kopi / Minuman
                </button>
            </div>
        </div>

        <form action="{{ route('order.post') }}" method="POST">
            @csrf

            <!-- Layanan Jasa -->
            <div style="margin-bottom: 1rem;">
                <label for="select-jasa" style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">
                    Jenis Kebutuhan Jasa <span style="color: var(--rose);">*</span>
                </label>
                <select name="jasa_id" id="select-jasa" required onchange="updateDefaultFee()" 
                    style="width: 100%; padding: 0.7rem 0.85rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.85rem; outline: none;">
                    <option value="">-- Pilih Jenis Kebutuhan --</option>
                    @foreach($jasaOptions as $opt)
                        <option value="{{ $opt->id }}" data-price="{{ (int)$opt->harga }}" data-name="{{ strtolower($opt->nama) }}">
                            {{ $opt->nama }} (Saran Tarif: Rp {{ number_format($opt->harga, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Route Inputs -->
            <div class="form-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1rem;">
                <div>
                    <label for="input-jemput" style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">
                        <i class="fa-solid fa-store" style="color: var(--accent);"></i> Titik Jemput / Beli <span style="color: var(--rose);">*</span>
                    </label>
                    <input type="text" name="lokasi_jemput" id="input-jemput" required placeholder="Contoh: Kantin Biru / Fotocopy Perpus" list="list-jemput"
                        style="width: 100%; padding: 0.68rem 0.85rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.825rem; outline: none;">
                    <datalist id="list-jemput">
                        <option value="Kantin Pusat Kampus"></option>
                        <option value="Kantin Biru Gedung A"></option>
                        <option value="Fotocopy & Print Perpustakaan"></option>
                        <option value="Pos Satpam Gerbang Utama"></option>
                        <option value="Indomaret Point Depan Kampus"></option>
                    </datalist>
                </div>
                <div>
                    <label for="input-antar" style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">
                        <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i> Titik Antar ke Kamu <span style="color: var(--rose);">*</span>
                    </label>
                    <input type="text" name="lokasi_antar" id="input-antar" required placeholder="Contoh: Gedung C Ruang 304 / Lab" list="list-antar"
                        style="width: 100%; padding: 0.68rem 0.85rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.825rem; outline: none;">
                    <datalist id="list-antar">
                        <option value="Gedung Kuliah Bersama Ruang 204"></option>
                        <option value="Lab Komputer Fasilkom Lantai 3"></option>
                        <option value="Perpustakaan Pusat Lantai 2 (Area Baca)"></option>
                        <option value="Gazebo Dekat Rektorat"></option>
                        <option value="Asrama Mahasiswa Blok B"></option>
                    </datalist>
                </div>
            </div>

            <!-- Notes & Description -->
            <div style="margin-bottom: 1rem;">
                <label for="input-deskripsi" style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">
                    Rincian Barang / Catatan Pesanan <span style="color: var(--rose);">*</span>
                </label>
                <textarea name="deskripsi" id="input-deskripsi" required rows="3" placeholder="Contoh: Titip beli nasi ayam bakar sambal terasi + es jeruk di Bu Sri. Uang makan Rp 18.000 dibayar tunai saat pesanan diserahkan."
                    style="width: 100%; padding: 0.75rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.825rem; outline: none; line-height: 1.45;"></textarea>
            </div>

            <!-- Ongkos & Waktu -->
            <div class="form-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1.25rem;">
                <div>
                    <label for="input-ongkos" style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">
                        Ongkos untuk Runner (Rp) <span style="color: var(--rose);">*</span>
                    </label>
                    <input type="number" inputmode="numeric" id="input-ongkos" name="ongkos" required min="3000" step="500" value="8000"
                        style="width: 100%; padding: 0.68rem 0.85rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--primary); font-size: 1.05rem; font-weight: 800; outline: none;">
                    <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 3px;">Min. Rp 3.000 (Saran wajar kampus)</div>
                </div>
                <div>
                    <label for="input-jadwal" style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">
                        Batas Jam Diantar
                    </label>
                    <input type="datetime-local" id="input-jadwal" name="jadwal" value="{{ now()->addMinutes(40)->format('Y-m-d\TH:i') }}"
                        style="width: 100%; padding: 0.68rem 0.85rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.825rem; outline: none;">
                </div>
            </div>

            <!-- Submit Button -->
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.85rem; font-weight: 800; font-size: 0.925rem; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);">
                    <i class="fa-solid fa-paper-plane"></i> Posting ke Live Pool
                </button>
                <button type="button" onclick="closeCreateModal()" class="btn btn-outline" style="padding: 0.85rem;">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Modal controls
    function openCreateModal() {
        document.getElementById('modal-buat-orderan').style.display = 'flex';
        setTimeout(function () { document.getElementById('select-jasa')?.focus(); }, 50);
    }

    function closeCreateModal() {
        document.getElementById('modal-buat-orderan').style.display = 'none';
    }

    // Auto open modal if URL hash is #buat-order
    window.addEventListener('DOMContentLoaded', function() {
        if (window.location.hash === '#buat-order') {
            openCreateModal();
        }
    });

    // Update fee based on selected service
    function updateDefaultFee() {
        const select = document.getElementById('select-jasa');
        const selected = select.options[select.selectedIndex];
        const price = selected.getAttribute('data-price');
        if (price) {
            document.getElementById('input-ongkos').value = price;
        }
    }

    // Quick template applicator
    function applyTemplate(type) {
        const select = document.getElementById('select-jasa');
        const jemput = document.getElementById('input-jemput');
        const antar = document.getElementById('input-antar');
        const deskripsi = document.getElementById('input-deskripsi');
        const ongkos = document.getElementById('input-ongkos');

        if (type === 'makan') {
            // Cari opsi jasa makanan
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].text.toLowerCase().includes('makan') || select.options[i].text.toLowerCase().includes('kantin')) {
                    select.selectedIndex = i;
                    break;
                }
            }
            jemput.value = 'Kantin Pusat Kampus (Stand Bu Sri)';
            antar.value = 'Gedung C Ruang 304';
            deskripsi.value = 'Titip beli nasi ayam geprek sambal matah level 2 + es teh manis. Uang makanan Rp 18.000 dibayar langsung saat serah terima.';
            ongkos.value = 8000;
        } else if (type === 'print') {
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].text.toLowerCase().includes('print') || select.options[i].text.toLowerCase().includes('skripsi')) {
                    select.selectedIndex = i;
                    break;
                }
            }
            jemput.value = 'Fotocopy & Print Perpustakaan';
            antar.value = 'Lab Komputer Lantai 3';
            deskripsi.value = 'Tolong ambilkan print tugas makalah 12 lembar hitam putih file sudah dikirim via WA ke tempat fotocopy.';
            ongkos.value = 5000;
        } else if (type === 'paket') {
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].text.toLowerCase().includes('paket') || select.options[i].text.toLowerCase().includes('satpam')) {
                    select.selectedIndex = i;
                    break;
                }
            }
            jemput.value = 'Pos Satpam Gerbang Utama';
            antar.value = 'Asrama Mahasiswa Gedung B';
            deskripsi.value = 'Titip ambil paket Shopee atas nama Tegar (resi J&T 882190). Ukuran paket kecil baju kaos.';
            ongkos.value = 7000;
        } else if (type === 'kopi') {
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].text.toLowerCase().includes('makan') || select.options[i].text.toLowerCase().includes('titip')) {
                    select.selectedIndex = i;
                    break;
                }
            }
            jemput.value = 'Indomaret Point Depan Kampus';
            antar.value = 'Perpustakaan Pusat Lantai 2 (Area Baca)';
            deskripsi.value = 'Titip es kopi gula aren 1 cup normal ice. Mohon jangan tumpah ya kak.';
            ongkos.value = 6000;
        }
    }

    // Live Ticker simulation for production feel
    const tickerUpdates = [
        "🚀 <strong>Sendy (Runner)</strong> baru saja menyelesaikan titip cetak laporan di Lab Komputer • 2 menit lalu",
        "🍔 <strong>Budi (Runner)</strong> sedang mengantar Nasi Geprek ke Gedung C Ruang 201 • Baru saja",
        "📦 <strong>Tegar</strong> baru memposting titipan ambil paket dari Pos Satpam • 4 menit lalu",
        "✨ <strong>Citra (Mahasiswi)</strong> memberi rating 5★ untuk Runner cepat tanggap • 10 menit lalu"
    ];
    let tickerIndex = 0;
    setInterval(function() {
        tickerIndex = (tickerIndex + 1) % tickerUpdates.length;
        const elem = document.getElementById('liveTickerText');
        if (elem) {
            elem.style.opacity = 0;
            setTimeout(() => {
                elem.innerHTML = tickerUpdates[tickerIndex];
                elem.style.opacity = 1;
            }, 300);
        }
    }, 5000);
</script>
@endsection
