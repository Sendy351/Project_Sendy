<?php

namespace Database\Seeders;

use App\Models\PenyediaJasa;
use App\Models\User;
use Illuminate\Database\Seeder;

class PenyediaJasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hendraUser = User::where('email', 'hendra.ac@gmail.com')->first();
        $dewiUser = User::where('email', 'berkah.cleaning@gmail.com')->first();
        $jokoUser = User::where('email', 'bengkel.jaya@gmail.com')->first();

        $penyedia = [
            [
                'pengguna_id' => $hendraUser?->id,
                'nama' => 'Hendra Cool AC Service',
                'telepon' => '081399887766',
                'alamat' => 'Jl. Gatot Subroto No. 88, Bandung',
                'deskripsi' => 'Spesialis perbaikan, cuci, bongkar pasang AC semua merk bergaransi 30 hari.',
                'status' => 'aktif',
                'rating' => 4.90,
            ],
            [
                'pengguna_id' => $dewiUser?->id,
                'nama' => 'Berkah Clean Home Service',
                'telepon' => '081277665544',
                'alamat' => 'Jl. Asia Afrika No. 20, Bandung',
                'deskripsi' => 'Jasa kebersihan rumah, sedot debu/tungau kasur, cuci sofa, dan pembersihan toilet berkerak.',
                'status' => 'aktif',
                'rating' => 4.85,
            ],
            [
                'pengguna_id' => $jokoUser?->id,
                'nama' => 'Bengkel Motor Mas Joko',
                'telepon' => '082233445566',
                'alamat' => 'Jl. Soekarno Hatta No. 101, Bandung',
                'deskripsi' => 'Mekanik motor panggilan, ganti oli, tune up, servis CVT, dan emergency mogok di jalan.',
                'status' => 'aktif',
                'rating' => 4.75,
            ],
        ];

        foreach ($penyedia as $item) {
            if ($item['pengguna_id']) {
                PenyediaJasa::updateOrCreate(
                    ['pengguna_id' => $item['pengguna_id']],
                    $item
                );
            }
        }
    }
}
