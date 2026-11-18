<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PesanChat;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Chat in-app per pesanan antara pemesan dan runner (teks + foto lokasi).
 */
class ChatController extends Controller
{
    private const FOTO_MAKS_SISI = 1600; // px, sisi terpanjang
    private const FOTO_KUALITAS = 80;    // JPEG quality

    /**
     * Ambil pesan (dipakai polling). ?after=ID untuk ambil yang lebih baru saja.
     */
    public function index(Request $request, $id)
    {
        $pesanan = $this->pesananPeserta($id);
        $userId = Auth::id();

        $query = PesanChat::with('pengirim:id,nama')
            ->where('pesanan_id', $pesanan->id)
            ->orderBy('id');

        if ($request->filled('after')) {
            $query->where('id', '>', (int) $request->after);
        }

        $pesan = $query->limit(200)->get();

        // Tandai pesan dari lawan chat sebagai sudah dibaca
        PesanChat::where('pesanan_id', $pesanan->id)
            ->where('pengirim_id', '!=', $userId)
            ->whereNull('dibaca_pada')
            ->update(['dibaca_pada' => now()]);

        return response()->json([
            'pesan' => $pesan->map(fn ($p) => $this->format($p, $userId)),
        ]);
    }

    /**
     * Kirim pesan teks dan/atau foto.
     */
    public function store(Request $request, $id)
    {
        $pesanan = $this->pesananPeserta($id);

        if ($pesanan->status === 'dibatalkan') {
            return response()->json(['message' => 'Pesanan sudah dibatalkan, chat ditutup.'], 422);
        }

        $request->validate([
            'isi' => 'nullable|string|max:2000',
            'foto' => 'nullable|file|image|mimes:jpeg,jpg,png,webp|max:8192',
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 8 MB.',
            'isi.max' => 'Pesan maksimal 2000 karakter.',
        ]);

        $isi = trim((string) $request->input('isi', ''));
        if ($isi === '' && !$request->hasFile('foto')) {
            return response()->json(['message' => 'Tulis pesan atau pilih foto dulu.'], 422);
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $this->simpanFoto($request->file('foto'), $pesanan->id);
            if (!$fotoPath) {
                return response()->json(['message' => 'Foto tidak bisa diproses. Coba foto lain.'], 422);
            }
        }

        $pesan = PesanChat::create([
            'pesanan_id' => $pesanan->id,
            'pengirim_id' => Auth::id(),
            'isi' => $isi !== '' ? $isi : null,
            'foto_path' => $fotoPath,
        ]);
        $pesan->load('pengirim:id,nama');

        return response()->json(['pesan' => $this->format($pesan, Auth::id())], 201);
    }

    /**
     * Tampilkan foto chat (privat, hanya peserta chat).
     */
    public function foto($pesanId)
    {
        $pesan = PesanChat::findOrFail($pesanId);
        $this->pesananPeserta($pesan->pesanan_id);

        if (!$pesan->foto_path || !Storage::disk('local')->exists($pesan->foto_path)) {
            abort(404);
        }

        return response()->file(Storage::disk('local')->path($pesan->foto_path), [
            'Content-Type' => 'image/jpeg',
            'Cache-Control' => 'private, max-age=86400',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Pesanan hanya boleh diakses pemesan atau runner-nya.
     */
    private function pesananPeserta($id): Pesanan
    {
        $pesanan = Pesanan::with('penyedia')->findOrFail($id);
        $userId = Auth::id();

        $isPemesan = (int) $pesanan->pengguna_id === (int) $userId;
        $isRunner = $pesanan->penyedia && (int) $pesanan->penyedia->pengguna_id === (int) $userId;

        abort_unless($isPemesan || $isRunner, 403, 'Kamu bukan peserta chat pesanan ini.');

        return $pesanan;
    }

    /**
     * Re-encode foto ke JPEG (maks 1600px). Sekalian membuang metadata EXIF/GPS
     * dan memastikan isinya benar-benar gambar.
     */
    private function simpanFoto($file, int $pesananId): ?string
    {
        $data = @file_get_contents($file->getRealPath());
        $src = $data !== false ? @imagecreatefromstring($data) : false;
        if (!$src) {
            return null;
        }

        // Ikuti orientasi EXIF (foto HP sering tersimpan miring)
        if (function_exists('exif_read_data') && in_array($file->getMimeType(), ['image/jpeg', 'image/jpg'])) {
            $exif = @exif_read_data($file->getRealPath());
            $rot = ['3' => 180, '6' => -90, '8' => 90][(string) ($exif['Orientation'] ?? '')] ?? 0;
            if ($rot) {
                $rotated = imagerotate($src, $rot, 0);
                if ($rotated) {
                    imagedestroy($src);
                    $src = $rotated;
                }
            }
        }

        $w = imagesx($src);
        $h = imagesy($src);
        $scale = min(1, self::FOTO_MAKS_SISI / max($w, $h));
        $nw = max(1, (int) round($w * $scale));
        $nh = max(1, (int) round($h * $scale));

        $dst = imagecreatetruecolor($nw, $nh);
        imagefill($dst, 0, 0, imagecolorallocate($dst, 255, 255, 255)); // latar putih untuk PNG transparan
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

        ob_start();
        imagejpeg($dst, null, self::FOTO_KUALITAS);
        $jpeg = ob_get_clean();
        imagedestroy($src);
        imagedestroy($dst);

        $path = 'chat/' . $pesananId . '/' . Str::uuid() . '.jpg';
        Storage::disk('local')->put($path, $jpeg);

        return $path;
    }

    private function format(PesanChat $p, $userId): array
    {
        return [
            'id' => $p->id,
            'milik_saya' => (int) $p->pengirim_id === (int) $userId,
            'pengirim' => $p->pengirim->nama ?? 'Pengguna',
            'isi' => $p->isi,
            'foto_url' => $p->foto_path ? route('chat.foto', $p->id) : null,
            'waktu' => optional($p->dibuat_pada)->format('H:i'),
            'tanggal' => optional($p->dibuat_pada)->format('d M Y'),
            'dibaca' => (bool) $p->dibaca_pada,
        ];
    }
}
