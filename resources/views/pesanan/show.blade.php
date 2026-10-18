@extends('layouts.jasakita')

@section('title', 'Tracking Pesanan #ORD-' . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) . ' - JasaKita')

@section('styles')
<style>
    .order-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.75rem;
        align-items: start;
    }

    .stepper-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
    }

    .order-sidebar {
        position: sticky;
        top: 85px;
    }

    /* Campus Route Visual Map Mockup */
    .campus-map-box {
        background: #F1F5F9;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .campus-map-bg {
        background: linear-gradient(135deg, #E2E8F0 25%, transparent 25%) -20px 0/ 40px 40px,
                    linear-gradient(225deg, #E2E8F0 25%, transparent 25%) -20px 0/ 40px 40px,
                    linear-gradient(315deg, #E2E8F0 25%, transparent 25%) 0 0/ 40px 40px,
                    linear-gradient(45deg, #E2E8F0 25%, #F8FAFC 25%) 0 0/ 40px 40px;
        position: absolute;
        inset: 0;
        opacity: 0.5;
        pointer-events: none;
    }

    .route-path-container {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
        padding: 1rem 1.25rem;
        border-radius: 12px;
        border: 1px solid var(--border);
    }

    .runner-profile-card {
        background: #FFFFFF;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-sm);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .qris-box {
        background: #FFFFFF;
        border: 2px dashed #CBD5E1;
        border-radius: 14px;
        padding: 1.25rem;
        text-align: center;
        margin-bottom: 1rem;
    }

    @media (max-width: 868px) {
        .order-layout {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
        .order-sidebar {
            position: static;
        }
    }

    @media (max-width: 540px) {
        .stepper-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Back Button -->
<div style="margin-bottom: 1.25rem;">
    <a href="{{ route('pesanan.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat Pesanan
    </a>
</div>

<!-- Header Info & Order ID -->
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 12px;">
    <div>
        <div style="display: flex; align-items: center; gap: 8px;">
            <span style="font-family: 'JetBrains Mono', monospace; background: #EFF6FF; color: var(--primary); font-weight: 800; font-size: 0.825rem; padding: 3px 8px; border-radius: 6px;">
                #ORD-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}
            </span>
            <span style="font-size: 0.775rem; color: var(--text-muted);">
                • Dipesan {{ date('d F Y, H:i', strtotime($pesanan->dibuat_pada)) }} WIB
            </span>
        </div>
        <h1 style="font-size: 1.55rem; font-weight: 800; color: var(--text-main); margin-top: 4px; letter-spacing: -0.5px;">
            {{ $pesanan->permintaanJasa->jasa->nama ?? 'Layanan On-Demand Kampus' }}
        </h1>
    </div>

    <div>
        @php
            $statusColors = [
                'menunggu' => ['bg' => 'var(--amber-light)', 'text' => 'var(--amber)', 'border' => '#FDE68A', 'icon' => 'clock', 'label' => 'MENUNGGU RUNNER'],
                'diterima' => ['bg' => 'var(--primary-light)', 'text' => 'var(--primary)', 'border' => '#BFDBFE', 'icon' => 'user-check', 'label' => 'RUNNER DITUGASKAN'],
                'dimulai' => ['bg' => '#F3E8FF', 'text' => '#9333EA', 'border' => '#E9D5FF', 'icon' => 'person-biking', 'label' => 'SEDANG DIANTAR / DIKERJAKAN'],
                'selesai' => ['bg' => 'var(--accent-light)', 'text' => 'var(--accent)', 'border' => '#A7F3D0', 'icon' => 'circle-check', 'label' => 'SELESAI TERKIRIM'],
                'dibatalkan' => ['bg' => 'var(--rose-light)', 'text' => 'var(--rose)', 'border' => '#FECDD3', 'icon' => 'circle-xmark', 'label' => 'DIBATALKAN'],
            ];
            $st = $statusColors[$pesanan->status] ?? $statusColors['menunggu'];
        @endphp
        <span style="background: {{ $st['bg'] }}; color: {{ $st['text'] }}; border: 1px solid {{ $st['border'] }}; padding: 6px 14px; border-radius: 999px; font-size: 0.8rem; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; box-shadow: var(--shadow-sm);">
            <i class="fa-solid fa-{{ $st['icon'] }}"></i> {{ $st['label'] }}
        </span>
    </div>
</div>

<!-- Stepper Lifecycle Pesanan Real-time -->
<div class="card" style="padding: 1.25rem 1.5rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 16px; margin-bottom: 1.5rem; box-shadow: var(--shadow-sm);">
    <div class="stepper-grid">
        @php
            $steps = [
                ['key' => 'menunggu', 'title' => 'Order Dibuat', 'desc' => 'Masuk ke pool'],
                ['key' => 'diterima', 'title' => 'Runner Claim', 'desc' => 'Tugas diambil'],
                ['key' => 'dimulai', 'title' => 'Dalam Proses', 'desc' => 'Menuju lokasi'],
                ['key' => 'selesai', 'title' => 'Selesai', 'desc' => 'Barang diterima'],
            ];
            $stepKeys = ['menunggu', 'diterima', 'dimulai', 'selesai'];
            $currentIndex = array_search($pesanan->status, $stepKeys);
            if ($currentIndex === false) $currentIndex = -1;
        @endphp

        @foreach($steps as $idx => $step)
            @php 
                $isDone = $idx <= $currentIndex; 
                $isCurrent = $idx === $currentIndex;
            @endphp
            <div style="text-align: center; background: {{ $isCurrent ? '#EFF6FF' : 'var(--bg-page)' }}; padding: 10px; border-radius: 12px; border: 1px solid {{ $isCurrent ? '#BFDBFE' : 'var(--border)' }}; transition: all 0.2s;">
                <div style="width: 32px; height: 32px; border-radius: 50%; margin: 0 auto 6px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.825rem; background: {{ $isDone ? 'var(--primary)' : 'var(--bg-subtle)' }}; color: {{ $isDone ? '#FFFFFF' : 'var(--text-muted)' }}; border: 2px solid {{ $isDone ? 'var(--primary)' : 'var(--border)' }};">
                    @if($isCurrent && $pesanan->status !== 'selesai')
                        <i class="fa-solid fa-spinner fa-spin" style="font-size: 0.75rem;"></i>
                    @elseif($isDone)
                        ✓
                    @else
                        {{ $idx + 1 }}
                    @endif
                </div>
                <div style="font-weight: 800; font-size: 0.8rem; color: {{ $isDone ? 'var(--text-main)' : 'var(--text-muted)' }};">
                    {{ $step['title'] }}
                </div>
                <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 2px;">
                    {{ $step['desc'] }}
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Campus Route Visual Map Mockup -->
@php
    $lokasiParts = explode('-> Antar ke:', $pesanan->permintaanJasa->lokasi);
    $jemput = str_replace('Ambil:', '', $lokasiParts[0] ?? $pesanan->permintaanJasa->lokasi);
    $antar = $lokasiParts[1] ?? 'Area Kampus';
@endphp
<div class="campus-map-box">
    <div class="campus-map-bg"></div>
    <div class="route-path-container">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="width: 36px; height: 36px; border-radius: 10px; background: #DCFCE7; color: #16A34A; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                <i class="fa-solid fa-store"></i>
            </div>
            <div>
                <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Titik Jemput / Beli</div>
                <div style="font-weight: 700; color: var(--text-main); font-size: 0.875rem;">{{ trim($jemput) }}</div>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; align-items: center; padding: 0 1rem;">
            <div style="display: flex; align-items: center; gap: 6px; font-size: 0.725rem; font-weight: 700; color: var(--primary); background: #EFF6FF; padding: 2px 8px; border-radius: 999px;">
                <span class="pulse-dot blue"></span> 
                {{ $pesanan->status === 'selesai' ? 'Tiba di Lokasi' : 'Estimasi: 5 - 10 Menit' }}
            </div>
            <div style="color: #94A3B8; font-size: 0.75rem; margin-top: 2px;">
                •••••••• <i class="fa-solid fa-person-running" style="color: var(--primary);"></i> ••••••••
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 10px; text-align: right;">
            <div>
                <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Titik Antar ke Pemesan</div>
                <div style="font-weight: 700; color: var(--primary); font-size: 0.875rem;">{{ trim($antar) }}</div>
            </div>
            <div style="width: 36px; height: 36px; border-radius: 10px; background: #EFF6FF; color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                <i class="fa-solid fa-location-dot"></i>
            </div>
        </div>
    </div>
</div>

@php
    $currentUserId = Auth::id();
    $isPemesan = ($currentUserId === $pesanan->pengguna_id);
    $isRunner = ($currentUserId === $pesanan->penyedia->pengguna_id) || (Auth::user()->isPenyedia() && Auth::user()->penyediaJasa?->id === $pesanan->penyedia_id);
    $isAdmin = Auth::user()->isAdmin();
@endphp

<!-- 2-Column Order Layout Responsive -->
<div class="order-layout">
    
    <!-- Left Column: Details & Runner/Customer Card -->
    <div>
        <!-- Role Notice Banner -->
        <div style="background: {{ $isRunner ? '#ECFDF5' : '#EFF6FF' }}; border: 1px solid {{ $isRunner ? '#A7F3D0' : '#BFDBFE' }}; border-radius: 12px; padding: 0.75rem 1.15rem; margin-bottom: 1.25rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-{{ $isRunner ? 'person-running' : 'user-check' }}" style="color: {{ $isRunner ? 'var(--accent)' : 'var(--primary)' }}; font-size: 1.1rem;"></i>
                <div style="font-size: 0.85rem; font-weight: 700; color: {{ $isRunner ? '#065F46' : '#1E40AF' }};">
                    Peran Anda di Sini: {{ $isRunner ? 'Mitra Runner (Pengantar & Penerima Ongkos)' : ($isPemesan ? 'Mahasiswa Pemesan (Pembayar Ongkos & Penerima Barang)' : 'Administrator Kampus') }}
                </div>
            </div>
            <span style="font-size: 0.725rem; color: var(--text-muted);">Akun Login: {{ Auth::user()->nama }}</span>
        </div>

        <!-- Counterpart Profile Card (Jika Pemesan -> Tampilkan Runner; Jika Runner -> Tampilkan Pemesan) -->
        <div class="runner-profile-card">
            @if($isRunner)
                <!-- Tampilan untuk Runner: Melihat data Mahasiswa Pemesan yang harus diantar -->
                @php
                    $rawPhone = preg_replace('/[^0-9]/', '', $pesanan->pengguna->telepon ?: '08123456789');
                    if (str_starts_with($rawPhone, '0')) { $rawPhone = '62' . substr($rawPhone, 1); }
                    $waMessage = urlencode("Halo {$pesanan->pengguna->nama}, saya Runner JasaKita ({$pesanan->penyedia->nama}) untuk pesanan #ORD-" . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) . ". Titipan Anda sedang saya proses ya.");
                @endphp
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 46px; height: 46px; border-radius: 50%; background: #EFF6FF; color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 800; border: 1px solid #BFDBFE;">
                        {{ strtoupper(substr($pesanan->pengguna->nama, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Tujuan Pengantaran ke:</div>
                        <div style="font-weight: 800; color: var(--text-main); font-size: 0.95rem;">{{ $pesanan->pengguna->nama }} (Pemesan)</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">
                            {{ $pesanan->pengguna->telepon ?: '08123456789' }} • {{ $pesanan->pengguna->email }}
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="https://wa.me/{{ $rawPhone }}?text={{ $waMessage }}" target="_blank" class="btn" style="background: #25D366; color: white; padding: 0.55rem 0.95rem; font-size: 0.8rem; font-weight: 700; border-radius: 999px;">
                        <i class="fa-brands fa-whatsapp" style="font-size: 1rem;"></i> Chat Pemesan
                    </a>
                </div>
            @else
                <!-- Tampilan untuk Pemesan: Melihat data Runner yang melayani -->
                @php
                    $rawPhone = preg_replace('/[^0-9]/', '', $pesanan->penyedia->telepon ?: '08123456789');
                    if (str_starts_with($rawPhone, '0')) { $rawPhone = '62' . substr($rawPhone, 1); }
                    $waMessage = urlencode("Halo kak {$pesanan->penyedia->nama}, saya pemesan jasa JasaKita #ORD-" . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) . " ({$pesanan->permintaanJasa->jasa->nama}). Posisi sekarang di mana ya kak?");
                @endphp
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 46px; height: 46px; border-radius: 50%; background: linear-gradient(135deg, #2563EB, #1D4ED8); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 800;">
                        {{ strtoupper(substr($pesanan->penyedia->nama, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Mitra Runner yang Mengantar:</div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <div style="font-weight: 800; color: var(--text-main); font-size: 0.95rem;">{{ $pesanan->penyedia->nama }}</div>
                            <span style="background: #FEF3C7; color: #92400E; font-size: 0.7rem; font-weight: 700; padding: 2px 6px; border-radius: 4px;">
                                <i class="fa-solid fa-star" style="color: #D97706;"></i> {{ number_format($pesanan->penyedia->rating, 1) }}
                            </span>
                        </div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 1px;">
                            Runner Kampus Terverifikasi • {{ $pesanan->penyedia->telepon ?: '08123456789' }}
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="https://wa.me/{{ $rawPhone }}?text={{ $waMessage }}" target="_blank" class="btn" style="background: #25D366; color: white; padding: 0.55rem 0.95rem; font-size: 0.8rem; font-weight: 700; border-radius: 999px;">
                        <i class="fa-brands fa-whatsapp" style="font-size: 1rem;"></i> Chat WhatsApp Runner
                    </a>
                </div>
            @endif
        </div>

        <!-- Order Information Card -->
        <div class="card" style="padding: 1.5rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 16px; margin-bottom: 1.5rem; box-shadow: var(--shadow-sm);">
            <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text-main); margin-bottom: 1rem;">
                <i class="fa-solid fa-file-lines" style="color: var(--primary);"></i> Rincian Pesanan
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.15rem;">
                <div>
                    <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Mahasiswa Pemesan:</div>
                    <div style="font-weight: 700; color: var(--text-main); font-size: 0.875rem; margin-top: 2px;">{{ $pesanan->pengguna->nama }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $pesanan->pengguna->email }}</div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Target Waktu Sampai:</div>
                    <div style="font-weight: 700; color: var(--text-main); font-size: 0.875rem; margin-top: 2px;">
                        <i class="fa-regular fa-clock" style="color: var(--primary);"></i> {{ date('d F Y, H:i', strtotime($pesanan->permintaanJasa->jadwal)) }} WIB
                    </div>
                    <div style="font-size: 0.75rem; color: var(--accent); font-weight: 600;">Prioritas Kampus</div>
                </div>
            </div>

            @if($pesanan->permintaanJasa->deskripsi)
                <div style="background: var(--bg-page); padding: 0.85rem 1rem; border-radius: 10px; border: 1px solid var(--border); margin-bottom: 1.25rem;">
                    <div style="font-size: 0.7rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 3px;">
                        Catatan Pesanan:
                    </div>
                    <div style="color: var(--text-main); font-size: 0.85rem; line-height: 1.5;">
                        "{{ $pesanan->permintaanJasa->deskripsi }}"
                    </div>
                </div>
            @endif

            <!-- Role-Based Action Section -->
            <div style="padding-top: 1.15rem; border-top: 1px solid var(--border);">
                @if($isRunner || $isAdmin)
                    <!-- AKSI KHUSUS RUNNER / PENGANTAR -->
                    <div style="font-size: 0.72rem; font-weight: 800; color: var(--accent); text-transform: uppercase; margin-bottom: 0.65rem;">
                        <i class="fa-solid fa-person-running"></i> Tindakan Anda sebagai Runner:
                    </div>

                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        @if($pesanan->status === 'diterima')
                            <form action="{{ route('pesanan.update_status', $pesanan->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="dimulai">
                                <button type="submit" class="btn btn-primary btn-sm" style="background: #9333EA; font-weight: 700;">
                                    <i class="fa-solid fa-person-running"></i> Mulai Ambil & Antar Sekarang
                                </button>
                            </form>
                        @elseif($pesanan->status === 'dimulai')
                            <form action="{{ route('pesanan.update_status', $pesanan->id) }}" method="POST" onsubmit="return confirmSwal(this, { title: 'Konfirmasi Serah Terima', text: 'Apakah barang/layanan sudah berhasil diserahkan kepada pemesan ({{ $pesanan->pengguna->nama }})?', icon: 'question', confirmButtonText: 'Ya, Tandai Selesai', confirmButtonColor: '#10B981' });">
                                @csrf
                                <input type="hidden" name="status" value="selesai">
                                <button type="submit" class="btn btn-emerald btn-sm" style="font-weight: 800;">
                                    <i class="fa-solid fa-circle-check"></i> Tandai Sudah Diserahkan ke Pemesan (Selesai)
                                </button>
                            </form>
                        @elseif($pesanan->status === 'selesai')
                            <span style="color: var(--accent); font-size: 0.8rem; font-weight: 700;">
                                <i class="fa-solid fa-circle-check"></i> Tugas Anda telah selesai. Terima kasih telah membantu sesama mahasiswa!
                            </span>
                        @endif
                    </div>
                @else
                    <!-- AKSI KHUSUS MAHASISWA PEMESAN -->
                    <div style="font-size: 0.72rem; font-weight: 800; color: var(--primary); text-transform: uppercase; margin-bottom: 0.65rem;">
                        <i class="fa-solid fa-user-check"></i> Status Pesanan Anda:
                    </div>

                    <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                        @if($pesanan->status === 'diterima')
                            <span style="font-size: 0.825rem; color: var(--text-secondary);">
                                <i class="fa-solid fa-spinner fa-spin" style="color: var(--primary);"></i> Runner <strong>{{ $pesanan->penyedia->nama }}</strong> telah mengambil orderanmu dan segera menuju lokasi jemput.
                            </span>
                        @elseif($pesanan->status === 'dimulai')
                            <span style="font-size: 0.825rem; color: var(--text-secondary); margin-right: 8px;">
                                <i class="fa-solid fa-person-running" style="color: #9333EA;"></i> Runner sedang mengantar pesanan ke lokasimu!
                            </span>
                            <form action="{{ route('pesanan.update_status', $pesanan->id) }}" method="POST" onsubmit="return confirmSwal(this, { title: 'Konfirmasi Penerimaan', text: 'Apakah titipan sudah Anda terima dengan baik dari Runner?', icon: 'question', confirmButtonText: 'Ya, Sudah Diterima', confirmButtonColor: '#10B981' });">
                                @csrf
                                <input type="hidden" name="status" value="selesai">
                                <button type="submit" class="btn btn-emerald btn-sm" style="font-weight: 700;">
                                    <i class="fa-solid fa-hand-holding"></i> Konfirmasi Sudah Saya Terima
                                </button>
                            </form>
                        @elseif($pesanan->status === 'selesai')
                            <span style="color: var(--accent); font-size: 0.825rem; font-weight: 700;">
                                <i class="fa-solid fa-circle-check"></i> Pesanan telah selesai dan diterima. Silakan beri ulasan bintang di bawah.
                            </span>
                        @endif

                        @if($pesanan->status !== 'selesai' && $pesanan->status !== 'dibatalkan')
                            <form action="{{ route('pesanan.update_status', $pesanan->id) }}" method="POST" onsubmit="return confirmSwal(this, { title: 'Batalkan Pesanan Ini?', text: 'Pesanan yang telah dibatalkan tidak dapat dilanjutkan kembali.', icon: 'warning', confirmButtonText: 'Ya, Batalkan', confirmButtonColor: '#E11D48' });" style="display: inline;">
                                @csrf
                                <input type="hidden" name="status" value="dibatalkan">
                                <button type="submit" class="btn btn-outline btn-sm" style="color: var(--rose); border-color: #FECDD3;">
                                    <i class="fa-solid fa-ban"></i> Batalkan Pesanan
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Ulasan Section (Jika Selesai) -->
        @if($pesanan->status === 'selesai')
            <div class="card" style="padding: 1.5rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 16px; box-shadow: var(--shadow-sm);">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.85rem;">
                    <i class="fa-solid fa-star" style="color: var(--amber);"></i> Ulasan & Penilaian Mahasiswa
                </h3>

                @if($pesanan->ulasan->isNotEmpty())
                    @foreach($pesanan->ulasan as $rev)
                        <div style="background: var(--bg-page); border: 1px solid var(--border); border-radius: 12px; padding: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                <span style="font-weight: 800; color: var(--text-main); font-size: 0.875rem;">{{ $rev->pengguna->nama }}</span>
                                <span style="color: var(--amber); font-size: 0.875rem;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-{{ $i <= $rev->rating ? 'solid' : 'regular' }} fa-star"></i>
                                    @endfor
                                    ({{ $rev->rating }}/5)
                                </span>
                            </div>
                            <p style="color: var(--text-secondary); font-size: 0.85rem; line-height: 1.5;">
                                "{{ $rev->komentar }}"
                            </p>
                        </div>
                    @endforeach
                @elseif($isPemesan || $isAdmin)
                    <form action="{{ route('pesanan.ulasan', $pesanan->id) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 0.85rem;">
                            <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 4px;">
                                Beri Rating Bintang Runner:
                            </label>
                            <select name="rating" required style="width: 100%; padding: 0.65rem 0.85rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 8px; color: var(--text-main); font-size: 0.85rem; outline: none;">
                                <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Cepat & Memuaskan)</option>
                                <option value="4">⭐⭐⭐⭐ (4 - Bagus & Tepat Waktu)</option>
                                <option value="3">⭐⭐⭐ (3 - Cukup Baik)</option>
                                <option value="2">⭐⭐ (2 - Agak Terlambat)</option>
                                <option value="1">⭐ (1 - Kurang Baik)</option>
                            </select>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 4px;">
                                Komentar & Testimoni:
                            </label>
                            <textarea name="komentar" rows="3" required placeholder="Contoh: Titipan makanan sampai masih hangat, runnernya sopan dan tepat waktu banget!" 
                                style="width: 100%; padding: 0.65rem 0.85rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 8px; color: var(--text-main); font-size: 0.825rem; outline: none; line-height: 1.45;"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Ulasan & Bintang
                        </button>
                    </form>
                @else
                    <p style="color: var(--text-muted); font-size: 0.825rem;">Menunggu ulasan dari pemesan.</p>
                @endif
            </div>
        @endif
    </div>

    <!-- Right Column: Role-Aware Payment Box -->
    <div>
        <div class="card order-sidebar" style="padding: 1.5rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 16px; box-shadow: var(--shadow-sm);">
            
            @if($isRunner)
                <!-- TAMPILAN SIDEBAR UNTUK RUNNER (PENERIMA ONGKOS) -->
                <div style="font-size: 0.72rem; font-weight: 800; color: var(--accent); text-transform: uppercase; margin-bottom: 0.65rem;">
                    <i class="fa-solid fa-wallet"></i> PENDAPATAN ONGKOS RUNNER
                </div>

                <div style="padding: 1.15rem; background: var(--bg-page); border: 1px solid var(--border); border-radius: 12px; margin-bottom: 1.25rem;">
                    <div style="font-size: 0.75rem; color: var(--text-muted);">Uang yang Anda Terima:</div>
                    <div style="font-size: 1.6rem; font-weight: 800; color: var(--accent); margin: 3px 0 8px; letter-spacing: -0.5px;">
                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </div>

                    @if($pesanan->pembayaran && $pesanan->pembayaran->status === 'berhasil')
                        <div style="background: var(--accent-light); border: 1px solid #A7F3D0; padding: 10px 12px; border-radius: 8px; font-size: 0.8rem; color: #065F46;">
                            <div style="font-weight: 800;"><i class="fa-solid fa-circle-check"></i> SUDAH DIBAYAR (LUNAS)</div>
                            <div style="margin-top: 4px; font-size: 0.725rem; color: #047857; line-height: 1.4;">
                                Metode: {{ strtoupper($pesanan->pembayaran->metode) }}<br>
                                Waktu: {{ date('d M Y, H:i', strtotime($pesanan->pembayaran->tanggal_pembayaran)) }} WIB
                            </div>
                        </div>
                    @else
                        <div style="background: var(--amber-light); border: 1px solid #FDE68A; padding: 10px 12px; border-radius: 8px; font-size: 0.8rem; color: #92400E; margin-bottom: 10px;">
                            <div style="font-weight: 800;"><i class="fa-solid fa-clock"></i> Belum Dibayar Pemesan</div>
                            <div style="font-size: 0.725rem; margin-top: 2px;">Pemesan dapat bayar via QRIS atau tunai langsung ke tangan Anda saat barang tiba.</div>
                        </div>

                        <!-- Runner can confirm cash receipt -->
                        <form action="{{ route('pesanan.bayar', $pesanan->id) }}" method="POST" onsubmit="return confirmSwal(this, { title: 'Konfirmasi Terima Uang Tunai?', text: 'Apakah pemesan sudah menyerahkan uang tunai sebesar Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }} secara langsung?', icon: 'question', confirmButtonText: 'Ya, Uang Tunai Diterima', confirmButtonColor: '#10B981' });">
                            @csrf
                            <input type="hidden" name="metode" value="tunai">
                            <button type="submit" class="btn btn-outline btn-sm" style="width: 100%; border-color: #10B981; color: #047857; font-weight: 700;">
                                <i class="fa-solid fa-hand-holding-dollar"></i> Konfirmasi Uang Tunai Diterima
                            </button>
                        </form>
                    @endif
                </div>

            @else
                <!-- TAMPILAN SIDEBAR UNTUK PEMESAN (PEMBAYAR ONGKOS) -->
                <div style="font-size: 0.72rem; font-weight: 800; color: var(--primary); text-transform: uppercase; margin-bottom: 0.65rem;">
                    <i class="fa-solid fa-receipt"></i> TAGIHAN ONGKOS ANDA
                </div>

                <div style="padding: 1.15rem; background: var(--bg-page); border: 1px solid var(--border); border-radius: 12px; margin-bottom: 1.25rem;">
                    <div style="font-size: 0.75rem; color: var(--text-muted);">Ongkos untuk Runner ({{ $pesanan->penyedia->nama }}):</div>
                    <div style="font-size: 1.6rem; font-weight: 800; color: var(--primary); margin: 3px 0 8px; letter-spacing: -0.5px;">
                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </div>

                    @if($pesanan->pembayaran && $pesanan->pembayaran->status === 'berhasil')
                        <div style="background: var(--accent-light); border: 1px solid #A7F3D0; padding: 10px 12px; border-radius: 8px; font-size: 0.8rem; color: #065F46;">
                            <div style="font-weight: 800;"><i class="fa-solid fa-circle-check"></i> LUNAS (TERVERIFIKASI)</div>
                            <div style="margin-top: 4px; font-size: 0.725rem; color: #047857; line-height: 1.4;">
                                Metode: {{ strtoupper($pesanan->pembayaran->metode) }}<br>
                                Waktu: {{ date('d M Y, H:i', strtotime($pesanan->pembayaran->tanggal_pembayaran)) }} WIB
                            </div>
                        </div>
                    @else
                        <div style="background: var(--amber-light); border: 1px solid #FDE68A; padding: 10px 12px; border-radius: 8px; font-size: 0.8rem; color: #92400E; margin-bottom: 10px;">
                            <div style="font-weight: 800;"><i class="fa-solid fa-clock"></i> Belum Dibayar</div>
                            <div style="font-size: 0.725rem; margin-top: 2px;">Sebagai pemesan, Anda dapat bayar lewat QRIS atau serahkan uang tunai ke Runner saat barang tiba.</div>
                        </div>

                        <button onclick="document.getElementById('modal-bayar').style.display='flex'" class="btn btn-emerald" style="width: 100%; padding: 0.8rem; font-weight: 800; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);">
                            <i class="fa-solid fa-wallet"></i> Bayar Ongkos ke Runner (QRIS/Tunai)
                        </button>
                    @endif
                </div>
            @endif

            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border); font-size: 0.75rem; color: var(--text-muted); line-height: 1.45;">
                <i class="fa-solid fa-shield-halved" style="color: var(--accent);"></i> Transaksi aman bergaransi komunitas mahasiswa kampus.
            </div>
        </div>
    </div>

</div>

<!-- Modal Pembayaran QRIS Simulator -->
<div id="modal-bayar" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #FFFFFF; border: 1px solid var(--border); border-radius: 18px; width: 100%; max-width: 440px; padding: 1.75rem; box-shadow: var(--shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <div>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--text-main);">Pembayaran Layanan</h3>
                <p style="font-size: 0.75rem; color: var(--text-muted);">Pilih metode pembayaran yang kamu inginkan</p>
            </div>
            <button onclick="document.getElementById('modal-bayar').style.display='none'" style="background: var(--bg-subtle); border: none; width: 30px; height: 30px; border-radius: 50%; color: var(--text-muted); font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <form action="{{ route('pesanan.bayar', $pesanan->id) }}" method="POST" onsubmit="return confirmSwal(this, { title: 'Konfirmasi Pelunasan?', text: 'Tagihan ongkos sebesar Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }} akan dicatat LUNAS.', icon: 'question', confirmButtonText: 'Ya, Konfirmasi Lunas', confirmButtonColor: '#10B981' });">
            @csrf

            <!-- QRIS Simulation Banner -->
            <div class="qris-box">
                <div style="font-size: 0.7rem; font-weight: 800; color: var(--rose); letter-spacing: 1px; margin-bottom: 4px;">QRIS STANDAR ASPI</div>
                <div style="font-size: 0.85rem; font-weight: 700; color: var(--text-main);">JASAKITA KAMPUS - RUNNER</div>
                
                <!-- Mock QR Code Visual -->
                <div style="width: 140px; height: 140px; background: #0F172A; margin: 10px auto; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; padding: 8px;">
                    <div style="width: 100%; height: 100%; background: white; border-radius: 6px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #0F172A;">
                        <i class="fa-solid fa-qrcode" style="font-size: 5rem;"></i>
                    </div>
                </div>

                <div style="font-size: 0.75rem; color: var(--text-muted);">
                    Scan pakai GoPay, OVO, ShopeePay, Dana, atau Mobile Banking
                </div>
                <div style="font-size: 1.25rem; font-weight: 800; color: var(--primary); margin-top: 4px;">
                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.78rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 6px;">
                    Konfirmasi Metode:
                </label>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; padding: 10px 12px; display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="radio" name="metode" value="qris" checked style="accent-color: var(--primary);">
                        <div style="font-weight: 700; color: var(--text-main); font-size: 0.85rem;">
                            <i class="fa-solid fa-qrcode" style="color: var(--primary);"></i> QRIS Instan (Simulasi Scan Berhasil)
                        </div>
                    </label>

                    <label style="background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; padding: 10px 12px; display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="radio" name="metode" value="tunai" style="accent-color: var(--primary);">
                        <div style="font-weight: 700; color: var(--text-main); font-size: 0.85rem;">
                            <i class="fa-solid fa-money-bill-wave" style="color: var(--accent);"></i> Tunai Saat Serah Terima Barang
                        </div>
                    </label>
                </div>
            </div>

            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-emerald" style="flex: 1; padding: 0.8rem; font-weight: 800;">
                    <i class="fa-solid fa-check"></i> Konfirmasi Pelunasan
                </button>
                <button type="button" onclick="document.getElementById('modal-bayar').style.display='none'" class="btn btn-outline" style="padding: 0.8rem;">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
