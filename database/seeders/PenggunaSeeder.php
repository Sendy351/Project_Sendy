<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penggunaList = [
            [
                'nama' => 'Administrator Jasa Kita',
                'email' => 'admin@jasakita.com',
                'kata_sandi' => Hash::make('password123'),
                'telepon' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 1, Jakarta Pusat',
                'peran' => 'admin',
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'kata_sandi' => Hash::make('password123'),
                'telepon' => '082198765432',
                'alamat' => 'Jl. Sudirman No. 45, Bandung',
                'peran' => 'pengguna',
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti@gmail.com',
                'kata_sandi' => Hash::make('password123'),
                'telepon' => '085712349988',
                'alamat' => 'Jl. Diponegoro No. 12, Surabaya',
                'peran' => 'pengguna',
            ],
            [
                'nama' => 'Hendra Prasetyo',
                'email' => 'hendra.ac@gmail.com',
                'kata_sandi' => Hash::make('password123'),
                'telepon' => '081399887766',
                'alamat' => 'Jl. Gatot Subroto No. 88, Bandung',
                'peran' => 'penyedia',
            ],
            [
                'nama' => 'Dewi Anggraeni',
                'email' => 'berkah.cleaning@gmail.com',
                'kata_sandi' => Hash::make('password123'),
                'telepon' => '081277665544',
                'alamat' => 'Jl. Asia Afrika No. 20, Bandung',
                'peran' => 'penyedia',
            ],
            [
                'nama' => 'Joko Wahyudi',
                'email' => 'bengkel.jaya@gmail.com',
                'kata_sandi' => Hash::make('password123'),
                'telepon' => '082233445566',
                'alamat' => 'Jl. Soekarno Hatta No. 101, Bandung',
                'peran' => 'penyedia',
            ],
        ];

        foreach ($penggunaList as $p) {
            User::updateOrCreate(
                ['email' => $p['email']],
                $p
            );
        }
    }
}
