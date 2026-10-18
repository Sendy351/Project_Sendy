<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Jasa;
use App\Models\KategoriJasa;
use App\Models\Pembayaran;
use App\Models\Pengguna;
use App\Models\PenyediaJasa;
use App\Models\PermintaanJasa;
use App\Models\Pesanan;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /**
     * Live Order Pool Feed (Halaman Utama ala Lalamove Kampus)
     */
    public function pool(Request $request)
    {
        $query = PermintaanJasa::with(['pengguna', 'jasa.kategori', 'pesanan'])
            ->where('status', 'menunggu');

        if ($request->filled('kategori_id')) {
            $query->whereHas('jasa', function ($q) use ($request) {
                $q->where('kategori_id', $request->kategori_id);
            });
        }

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('deskripsi', 'like', '%' . $request->q . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->q . '%');
            });
        }

        $openOrders = $query->latest('dibuat_pada')->paginate(10);
        $kategoriList = KategoriJasa::withCount('jasa')->get();
        $jasaOptions = Jasa::where('status', 'aktif')->get();

        return view('pool.index', compact('openOrders', 'kategoriList', 'jasaOptions'));
    }

    /**
     * Mahasiswa memposting orderan baru ke Pool Kampus (Open Order ala Lalamove)
     */
    public function postOrder(Request $request)
    {
        $request->validate([
            'jasa_id' => 'required|exists:jasa,id',
            'lokasi_jemput' => 'required|string|max:255',
            'lokasi_antar' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'ongkos' => 'required|numeric|min:2000',
            'jadwal' => 'nullable|date',
        ]);

        $user = Auth::user();
        $lokasiLengkap = "Ambil: {$request->lokasi_jemput} -> Antar ke: {$request->lokasi_antar}";

        $permintaan = PermintaanJasa::create([
            'pengguna_id' => $user->id,
            'jasa_id' => $request->jasa_id,
            'penyedia_id' => null, // Terbuka untuk runner mana saja di pool
            'deskripsi' => $request->deskripsi,
            'lokasi' => $lokasiLengkap,
            'jadwal' => $request->jadwal ? $request->jadwal : now()->addMinutes(45),
            'status' => 'menunggu',
            'total_harga' => $request->ongkos,
        ]);

        return redirect()->route('home')->with('success', 'Orderan berhasil diposting ke Pool Kampus! Menunggu runner mengambil orderanmu.');
    }

    /**
     * Mitra Runner / Driver Kampus meng-claim (Ambil Orderan) dari Pool
     */
    public function claimOrder($id, Request $request)
    {
        $permintaan = PermintaanJasa::where('status', 'menunggu')->findOrFail($id);
        $user = Auth::user();

        // Cegah pemesan mengambil orderannya sendiri
        if ($permintaan->pengguna_id === $user->id) {
            return back()->with('error', 'Anda tidak dapat mengambil orderan yang Anda buat sendiri.');
        }

        // Pastikan user memiliki profil penyedia_jasa (runner)
        $penyedia = $user->penyediaJasa;
        if (!$penyedia) {
            $penyedia = PenyediaJasa::create([
                'pengguna_id' => $user->id,
                'nama' => $user->nama . ' (Runner Kampus)',
                'telepon' => $user->telepon ?: '081200000000',
                'alamat' => $user->alamat ?: 'Area Kampus',
                'deskripsi' => 'Mitra runner aktif siap antar cepat di lingkungan kampus.',
                'status' => 'aktif',
                'rating' => 5.00,
            ]);

            // Ubah peran user jadi penyedia jika sebelumnya pelanggan
            $user->update(['peran' => 'penyedia']);
        }

        // 1. Update status permintaan_jasa
        $permintaan->update([
            'penyedia_id' => $penyedia->id,
            'status' => 'diambil',
        ]);

        // 2. Buat record transaksi pesanan
        $pesanan = Pesanan::create([
            'permintaan_id' => $permintaan->id,
            'penyedia_id' => $penyedia->id,
            'pengguna_id' => $permintaan->pengguna_id,
            'status' => 'diterima',
            'diterima_pada' => now(),
            'total_harga' => $permintaan->total_harga,
        ]);

        return redirect()->route('pesanan.show', $pesanan->id)->with('success', 'Selamat! Anda berhasil mengambil orderan ini. Silakan hubungi pemesan dan mulai pengerjaan.');
    }

    /**
     * Daftar Riwayat Pesanan Saya (Sebagai Pemesan atau Sebagai Runner)
     */
    public function index()
    {
        $user = Auth::user();
        $query = Pesanan::with(['pengguna', 'penyedia', 'permintaanJasa.jasa.kategori', 'pembayaran', 'ulasan']);

        if ($user->isPenyedia() && $user->penyediaJasa) {
            $query->where(function ($q) use ($user) {
                $q->where('penyedia_id', $user->penyediaJasa->id)
                  ->orWhere('pengguna_id', $user->id);
            });
        } elseif (!$user->isAdmin()) {
            $query->where('pengguna_id', $user->id);
        }

        $pesananList = $query->latest('dibuat_pada')->get();

        return view('pesanan.index', compact('pesananList'));
    }

    /**
     * Detail Pesanan & Tracking Live
     */
    public function show($id)
    {
        $pesanan = Pesanan::with([
            'pengguna',
            'penyedia.pengguna',
            'permintaanJasa.jasa.kategori',
            'pembayaran',
            'ulasan'
        ])->findOrFail($id);

        return view('pesanan.show', compact('pesanan'));
    }

    /**
     * Pelanggan memesan dari katalog jasa tertentu langsung
     */
    public function booking(Request $request)
    {
        $request->validate([
            'jasa_id' => 'required|exists:jasa,id',
            'lokasi' => 'required|string',
            'jadwal' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        $jasa = Jasa::findOrFail($request->jasa_id);
        $user = Auth::user();

        $permintaan = PermintaanJasa::create([
            'pengguna_id' => $user->id,
            'jasa_id' => $jasa->id,
            'penyedia_id' => $jasa->penyedia_id,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'jadwal' => $request->jadwal,
            'status' => 'diambil',
            'total_harga' => $jasa->harga,
        ]);

        $pesanan = Pesanan::create([
            'permintaan_id' => $permintaan->id,
            'penyedia_id' => $jasa->penyedia_id,
            'pengguna_id' => $user->id,
            'status' => 'diterima',
            'diterima_pada' => now(),
            'total_harga' => $jasa->harga,
        ]);

        return redirect()->route('pesanan.show', $pesanan->id)->with('success', 'Orderan berhasil dibuat dan diteruskan ke mitra penyedia!');
    }

    /**
     * Update status lifecycle pesanan (diterima -> dimulai -> selesai -> dibatalkan)
     */
    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $status = $request->validate([
            'status' => 'required|in:diterima,dimulai,selesai,dibatalkan',
        ])['status'];

        $updateData = ['status' => $status];

        if ($status === 'diterima' && !$pesanan->diterima_pada) {
            $updateData['diterima_pada'] = now();
        } elseif ($status === 'dimulai' && !$pesanan->dimulai_pada) {
            $updateData['dimulai_pada'] = now();
        } elseif ($status === 'selesai' && !$pesanan->selesai_pada) {
            $updateData['selesai_pada'] = now();
            $pesanan->permintaanJasa()->update(['status' => 'selesai']);
        }

        $pesanan->update($updateData);

        return back()->with('success', 'Status pesanan berhasil diperbarui: ' . strtoupper($status));
    }

    /**
     * Konfirmasi pembayaran pesanan
     */
    public function bayar(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $request->validate([
            'metode' => 'required|in:qris,transfer_bank,tunai,kartu_kredit',
        ]);

        Pembayaran::updateOrCreate(
            ['pesanan_id' => $pesanan->id],
            [
                'metode' => $request->metode,
                'jumlah' => $pesanan->total_harga,
                'status' => 'berhasil',
                'tanggal_pembayaran' => now(),
            ]
        );

        return back()->with('success', 'Pembayaran sebesar Rp ' . number_format($pesanan->total_harga, 0, ',', '.') . ' berhasil dikonfirmasi (LUNAS)!');
    }

    /**
     * Kirim ulasan dan rating untuk runner
     */
    public function kirimUlasan(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
        ]);

        Ulasan::create([
            'pesanan_id' => $pesanan->id,
            'pengguna_id' => Auth::id(),
            'penyedia_id' => $pesanan->penyedia_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        // Hitung ulang rata-rata rating penyedia
        $avg = Ulasan::where('penyedia_id', $pesanan->penyedia_id)->avg('rating');
        $pesanan->penyedia()->update(['rating' => round($avg, 2)]);

        return back()->with('success', 'Terima kasih! Ulasan dan rating bintang berhasil diberikan kepada runner.');
    }
}
