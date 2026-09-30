<?php

namespace Database\Seeders;

use App\Models\KategoriJasa;
use Illuminate\Database\Seeder;

class KategoriJasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            [
                'nama' => 'Servis AC & Elektronik',
                'deskripsi' => 'Perbaikan dan perawatan pendingin ruangan, kulkas, mesin cuci, dan elektronik lainnya.',
                'ikon' => 'snowflake',
            ],
            [
                'nama' => 'Kebersihan & Cleaning',
                'deskripsi' => 'Layanan jasa bersih-bersih rumah, kantor, sedot tungau kasur, dan cuci sofa.',
                'ikon' => 'broom',
            ],
            [
                'nama' => 'Otomotif Panggilan',
                'deskripsi' => 'Mekanik panggilan untuk servis rutin, ganti oli, aki tekor, dan darurat di jalan.',
                'ikon' => 'wrench',
            ],
            [
                'nama' => 'Tukang & Renovasi Bangunan',
                'deskripsi' => 'Tukang bangunan profesional untuk perbaikan atap bocor, cat dinding, plafon, dan ledeng.',
                'ikon' => 'hammer',
            ],
            [
                'nama' => 'Pindahan & Angkut Barang',
                'deskripsi' => 'Sewa pick-up dan tenaga angkut untuk pindahan kos, rumah, maupun kantor.',
                'ikon' => 'truck',
            ],
        ];

        foreach ($kategori as $item) {
            KategoriJasa::updateOrCreate(
                ['nama' => $item['nama']],
                $item
            );
        }
    }
}
