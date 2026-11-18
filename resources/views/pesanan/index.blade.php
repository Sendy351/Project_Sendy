@extends('layouts.jasakita')

@section('title', 'Pesanan & Transaksi Saya - JasaKita')

@section('styles')
<style>
    .order-table-card {
        display: block;
    }
    .order-mobile-list {
        display: none;
    }

    @media (max-width: 768px) {
        .order-table-card {
            display: none;
        }
        .order-mobile-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
    }
</style>
@endsection

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 12px;">
    <div>
        <span style="background: var(--primary-light); color: var(--primary); font-size: 0.725rem; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
            RIWAYAT AKTIF
        </span>
        <h1 style="font-size: 1.65rem; font-weight: 800; color: var(--text-main); margin-top: 4px; letter-spacing: -0.5px;">
            {{ (Auth::check() && Auth::user()->isPenyedia()) ? 'Pesanan Masuk (Mitra Runner)' : 'Daftar Pesanan & Titipan Saya' }}
        </h1>
        <p style="color: var(--text-muted); font-size: 0.825rem;">Pantau proses pengerjaan jasa, status pembayaran, dan feedback ulasan mahasiswa.</p>
    </div>

    <a href="{{ route('home') }}#buat-order" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-plus-circle"></i> Buat Orderan
    </a>
</div>

<!-- Desktop Table View -->
<div class="card order-table-card" style="padding: 0; background: #FFFFFF; border: 1px solid var(--border); overflow: hidden; border-radius: 16px; box-shadow: var(--shadow-sm);">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem; text-align: left;">
            <thead>
                <tr style="background: var(--bg-page); border-bottom: 1px solid var(--border); color: var(--text-secondary); font-size: 0.78rem; text-transform: uppercase;">
                    <th style="padding: 0.85rem 1.25rem;">No. Pesanan</th>
                    <th style="padding: 0.85rem 1.25rem;">Layanan Jasa</th>
                    <th style="padding: 0.85rem 1.25rem;">Lawan Transaksi</th>
                    <th style="padding: 0.85rem 1.25rem;">Total Ongkos</th>
                    <th style="padding: 0.85rem 1.25rem;">Status Delivery</th>
                    <th style="padding: 0.85rem 1.25rem;">Pembayaran</th>
                    <th style="padding: 0.85rem 1.25rem; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesananList as $item)
                    <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;" onmouseover="this.style.background='var(--bg-subtle)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 1rem 1.25rem; font-family: 'JetBrains Mono', monospace; font-size: 0.825rem; color: var(--primary); font-weight: 700;">
                            #ORD-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <td style="padding: 1rem 1.25rem;">
                            <div style="font-weight: 700; color: var(--text-main);">{{ $item->permintaanJasa->jasa->nama ?? 'Layanan On-Demand' }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;">
                                <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i> {{ Str::limit($item->permintaanJasa->lokasi ?? '-', 35) }}
                            </div>
                        </td>
                        <td style="padding: 1rem 1.25rem;">
                            {{-- Sebelumnya: kalau login sbg penyedia, SEMUA baris dianggap "pemesan", padahal list juga berisi orderan yg dia pesan sendiri --}}
                            @if($item->pengguna_id !== Auth::id())
                                <div style="font-size: 0.7rem; color: var(--text-muted); font-weight: 700;">PEMESAN</div>
                                <div style="font-weight: 600; color: var(--text-main);">{{ $item->pengguna->nama ?? 'Mahasiswa' }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $item->pengguna->telepon ?? '-' }}</div>
                            @else
                                <div style="font-size: 0.7rem; color: var(--text-muted); font-weight: 700;">RUNNER</div>
                                <div style="font-weight: 600; color: var(--text-main);">{{ $item->penyedia->nama ?? 'Mitra Kampus' }}</div>
                                <div style="font-size: 0.75rem; color: var(--amber);"><i class="fa-solid fa-star"></i> {{ number_format($item->penyedia->rating ?? 5.0, 1) }} (Runner)</div>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.25rem; font-weight: 800; color: var(--primary);">
                            Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                        </td>
                        <td style="padding: 1rem 1.25rem;">
                            @php
                                $statusColors = [
                                    'menunggu' => ['bg' => 'var(--amber-light)', 'text' => 'var(--amber)', 'border' => '#FDE68A', 'icon' => 'clock'],
                                    'diterima' => ['bg' => 'var(--primary-light)', 'text' => 'var(--primary)', 'border' => '#BFDBFE', 'icon' => 'user-check'],
                                    'dimulai' => ['bg' => '#F3E8FF', 'text' => '#9333EA', 'border' => '#E9D5FF', 'icon' => 'person-biking'],
                                    'selesai' => ['bg' => 'var(--accent-light)', 'text' => 'var(--accent)', 'border' => '#A7F3D0', 'icon' => 'circle-check'],
                                    'dibatalkan' => ['bg' => 'var(--rose-light)', 'text' => 'var(--rose)', 'border' => '#FECDD3', 'icon' => 'circle-xmark'],
                                ];
                                $st = $statusColors[$item->status] ?? $statusColors['menunggu'];
                                $statusLabel = ['menunggu' => 'MENUNGGU RUNNER', 'diterima' => 'RUNNER DITUGASKAN', 'dimulai' => 'SEDANG DIANTAR', 'selesai' => 'SELESAI', 'dibatalkan' => 'DIBATALKAN'];
                            @endphp
                            <span style="background: {{ $st['bg'] }}; color: {{ $st['text'] }}; border: 1px solid {{ $st['border'] }}; padding: 3px 9px; border-radius: 999px; font-size: 0.725rem; font-weight: 800; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-{{ $st['icon'] }}"></i> {{ $statusLabel[$item->status] ?? strtoupper($item->status) }}
                            </span>
                        </td>
                        <td style="padding: 1rem 1.25rem;">
                            @if($item->pembayaran && $item->pembayaran->status === 'berhasil')
                                <span style="background: var(--accent-light); color: var(--accent); border: 1px solid #A7F3D0; padding: 3px 8px; border-radius: 6px; font-size: 0.725rem; font-weight: 800;">
                                    <i class="fa-solid fa-check"></i> LUNAS ({{ strtoupper($item->pembayaran->metode) }})
                                </span>
                            @else
                                <span style="background: var(--amber-light); color: var(--amber); border: 1px solid #FDE68A; padding: 3px 8px; border-radius: 6px; font-size: 0.725rem; font-weight: 800;">
                                    <i class="fa-solid fa-hourglass-half"></i> BELUM BAYAR
                                </span>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.25rem; text-align: right;">
                            <a href="{{ route('pesanan.show', $item->id) }}" class="btn btn-outline btn-sm" style="font-size: 0.8rem;">
                                Lihat Detail <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 3.5rem 1rem; color: var(--text-muted);">
                            <i class="fa-solid fa-receipt" style="font-size: 2.5rem; color: var(--border); margin-bottom: 0.75rem; display: block;"></i>
                            Belum ada pesanan. Posting orderan pertamamu sekarang!<br>
                            <a href="{{ route('home') }}#buat-order" class="btn btn-primary btn-sm" style="margin-top: 1rem;"><i class="fa-solid fa-plus-circle"></i> Buat Orderan</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Mobile Cards View -->
<div class="order-mobile-list">
    @forelse($pesananList as $item)
        @php
            $statusColors = [
                'menunggu' => ['bg' => 'var(--amber-light)', 'text' => 'var(--amber)', 'border' => '#FDE68A', 'icon' => 'clock'],
                'diterima' => ['bg' => 'var(--primary-light)', 'text' => 'var(--primary)', 'border' => '#BFDBFE', 'icon' => 'user-check'],
                'dimulai' => ['bg' => '#F3E8FF', 'text' => '#9333EA', 'border' => '#E9D5FF', 'icon' => 'person-biking'],
                'selesai' => ['bg' => 'var(--accent-light)', 'text' => 'var(--accent)', 'border' => '#A7F3D0', 'icon' => 'circle-check'],
                'dibatalkan' => ['bg' => 'var(--rose-light)', 'text' => 'var(--rose)', 'border' => '#FECDD3', 'icon' => 'circle-xmark'],
            ];
            $st = $statusColors[$item->status] ?? $statusColors['menunggu'];
            $statusLabel = ['menunggu' => 'MENUNGGU RUNNER', 'diterima' => 'RUNNER DITUGASKAN', 'dimulai' => 'SEDANG DIANTAR', 'selesai' => 'SELESAI', 'dibatalkan' => 'DIBATALKAN'];
        @endphp
        <div class="card" style="padding: 1.15rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 14px; box-shadow: var(--shadow-sm);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: var(--primary); font-weight: 700;">
                    #ORD-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                </span>
                <span style="background: {{ $st['bg'] }}; color: {{ $st['text'] }}; border: 1px solid {{ $st['border'] }}; padding: 3px 8px; border-radius: 999px; font-size: 0.7rem; font-weight: 800; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="fa-solid fa-{{ $st['icon'] }}"></i> {{ $statusLabel[$item->status] ?? strtoupper($item->status) }}
                </span>
            </div>

            <h3 style="font-size: 1rem; font-weight: 800; color: var(--text-main); margin-bottom: 4px;">
                {{ $item->permintaanJasa->jasa->nama ?? 'Layanan On-Demand' }}
            </h3>

            <div style="font-size: 0.775rem; color: var(--text-muted); margin-bottom: 10px;">
                <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i> {{ Str::limit($item->permintaanJasa->lokasi ?? '-', 50) }}
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border); padding-top: 10px;">
                <div>
                    <div style="font-size: 0.7rem; color: var(--text-muted);">Total Biaya:</div>
                    <div style="font-size: 1.1rem; font-weight: 800; color: var(--primary);">
                        Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                    </div>
                </div>

                <a href="{{ route('pesanan.show', $item->id) }}" class="btn btn-primary btn-sm" style="padding: 0.5rem 1rem;">
                    Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 3rem 1rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 14px;">
            <i class="fa-solid fa-receipt" style="font-size: 2.25rem; color: var(--text-muted); margin-bottom: 0.5rem;"></i>
            <p style="font-size: 0.95rem; font-weight: 700; color: var(--text-main);">Belum ada pesanan</p>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 4px 0 1rem;">Posting orderan pertamamu, atau ambil orderan dari pool.</p>
            <a href="{{ route('home') }}#buat-order" class="btn btn-primary"><i class="fa-solid fa-plus-circle"></i> Buat Orderan</a>
        </div>
    @endforelse
</div>
@endsection
