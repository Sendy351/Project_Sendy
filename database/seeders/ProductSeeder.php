<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'code' => '10000001',
                'name' => 'Kertas HVS A4 80gr Satu Rim (500 Lembar)',
                'quantity' => 25,
                'price' => 52000.00,
                'description' => 'Kertas print tugas makalah, modul praktikum, dan skripsi.',
            ],
            [
                'code' => '10000002',
                'name' => 'Jilid Mika Bening + Lakban Hitam Standar Lab',
                'quantity' => 100,
                'price' => 5000.00,
                'description' => 'Bahan jilid jastip print praktikum mahasiswa.',
            ],
            [
                'code' => '10000003',
                'name' => 'Nasi Ayam Geprek Kantin Gedung B',
                'quantity' => 30,
                'price' => 15000.00,
                'description' => 'Paket makan siang jastip kantin kampus.',
            ],
            [
                'code' => '10000004',
                'name' => 'Stopmap Kancing Folio Bening Lab Jarkom',
                'quantity' => 60,
                'price' => 4500.00,
                'description' => 'Map plastik pengumpulan tugas laporan praktikum.',
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['code' => $p['code']], $p);
        }
    }
}
