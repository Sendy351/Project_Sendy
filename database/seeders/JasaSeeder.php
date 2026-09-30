<?php

namespace Database\Seeders;

use App\Models\Jasa;
use App\Models\KategoriJasa;
use App\Models\PenyediaJasa;
use Illuminate\Database\Seeder;

class JasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriAc = KategoriJasa::where('nama', 'like', '%AC%')->first();
        $kategoriClean = KategoriJasa::where('nama', 'like', '%Kebersihan%')->first();
        $kategoriOtomotif = KategoriJasa::where('nama', 'like', '%Otomotif%')->first();

        $penyediaHendra = PenyediaJasa::where('nama', 'like', '%Hendra%')->first();
        $penyediaBerkah = PenyediaJasa::where('nama', 'like', '%Berkah%')->first();
        $penyediaJoko = PenyediaJasa::where('nama', 'like', '%Joko%')->first();

        $daftarJasa = [
            [
                'kategori_id' => $kategoriAc?->id,
                'penyedia_id' => $penyediaHendra?->id,
                'nama' => 'Cuci AC Split Standard (0.5 - 1 PK)',
                'deskripsi' => 'Pembersihan evaporator, filter udara, blower indoor, dan kondensor outdoor agar dingin maksimal.',
                'harga' => 75000,
                'durasi' => '1 - 2 Jam',
                'gambar' => null,
                'status' => 'tersedia',
            ],
            [
                'kategori_id' => $kategoriAc?->id,
                'penyedia_id' => $penyediaHendra?->id,
                'nama' => 'Servis & Tambah Freon AC R32 / R410',
                'deskripsi' => 'Pengecekan kebocoran pipa dan pengisian freon jenis R32 / R410 hingga tekanan optimal.',
                'harga' => 150000,
                'durasi' => '1 - 2 Jam',
                'gambar' => null,
                'status' => 'tersedia',
            ],
            [
                'kategori_id' => $kategoriClean?->id,
                'penyedia_id' => $penyediaBerkah?->id,
                'nama' => 'Deep Cleaning Rumah / Kamar Kos',
                'deskripsi' => 'Pembersihan menyeluruh lantai, debu furnitur, kaca jendela, dan sanitasi kamar mandi.',
                'harga' => 120000,
                'durasi' => '2 - 3 Jam',
                'gambar' => null,
                'status' => 'tersedia',
            ],
            [
                'kategori_id' => $kategoriClean?->id,
                'penyedia_id' => $penyediaBerkah?->id,
                'nama' => 'Hydro Vacuum Sedot Tungau Kasur & Sofa',
                'deskripsi' => 'Penyedotan tungau debu alergi pada kasur springbed atau sofa dengan mesin filter air khusus.',
                'harga' => 95000,
                'durasi' => '1 Jam',
                'gambar' => null,
                'status' => 'tersedia',
            ],
            [
                'kategori_id' => $kategoriOtomotif?->id,
                'penyedia_id' => $penyediaJoko?->id,
                'nama' => 'Ganti Oli & Tune Up Motor Panggilan',
                'deskripsi' => 'Servis ringan motor matic/bebek di lokasi rumah/kantor pelanggan. Termasuk cek busi dan rem.',
                'harga' => 65000,
                'durasi' => '45 Menit',
                'gambar' => null,
                'status' => 'tersedia',
            ],
            [
                'kategori_id' => $kategoriOtomotif?->id,
                'penyedia_id' => $penyediaJoko?->id,
                'nama' => 'Layanan Darurat Jumper Aki / Ban Bocor',
                'deskripsi' => 'Pertolongan darurat untuk motor atau mobil mogok di area jalan kota Bandung.',
                'harga' => 50000,
                'durasi' => '30 - 60 Menit',
                'gambar' => null,
                'status' => 'tersedia',
            ],
        ];

        foreach ($daftarJasa as $jasa) {
            if ($jasa['kategori_id'] && $jasa['penyedia_id']) {
                Jasa::updateOrCreate(
                    [
                        'nama' => $jasa['nama'],
                        'penyedia_id' => $jasa['penyedia_id'],
                    ],
                    $jasa
                );
            }
        }
    }
}
