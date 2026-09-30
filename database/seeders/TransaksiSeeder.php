<?php

namespace Database\Seeders;

use App\Models\Jasa;
use App\Models\Pembayaran;
use App\Models\PermintaanJasa;
use App\Models\Pesanan;
use App\Models\Ulasan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $budi = User::where('email', 'budi@gmail.com')->first();
        $jasaAc = Jasa::with('penyedia')->where('nama', 'like', '%Cuci AC%')->first();

        if (! $budi || ! $jasaAc) {
            return;
        }

        // 1. Permintaan Jasa
        $permintaan = PermintaanJasa::updateOrCreate(
            [
                'pengguna_id' => $budi->id,
                'jasa_id' => $jasaAc->id,
            ],
            [
                'penyedia_id' => $jasaAc->penyedia_id,
                'deskripsi' => 'AC kamar tidur kurang dingin dan sudah berdebu. Mohon dicuci bersih.',
                'lokasi' => 'Jl. Sudirman No. 45, Bandung',
                'jadwal' => Carbon::now()->subDays(2),
                'status' => 'selesai',
                'total_harga' => $jasaAc->harga,
            ]
        );

        // 2. Pesanan
        $pesanan = Pesanan::updateOrCreate(
            ['permintaan_id' => $permintaan->id],
            [
                'penyedia_id' => $jasaAc->penyedia_id,
                'pengguna_id' => $budi->id,
                'status' => 'selesai',
                'diterima_pada' => Carbon::now()->subDays(2)->setHour(9),
                'dimulai_pada' => Carbon::now()->subDays(2)->setHour(10),
                'selesai_pada' => Carbon::now()->subDays(2)->setHour(11)->setMinute(30),
                'total_harga' => $jasaAc->harga,
            ]
        );

        // 3. Pembayaran
        Pembayaran::updateOrCreate(
            ['pesanan_id' => $pesanan->id],
            [
                'metode' => 'Transfer Bank (BCA)',
                'jumlah' => $jasaAc->harga,
                'status' => 'lunas',
                'tanggal_pembayaran' => Carbon::now()->subDays(2)->setHour(12),
            ]
        );

        // 4. Ulasan
        Ulasan::updateOrCreate(
            ['pesanan_id' => $pesanan->id],
            [
                'pengguna_id' => $budi->id,
                'penyedia_id' => $jasaAc->penyedia_id,
                'rating' => 5,
                'komentar' => 'Pelayanan sangat memuaskan! Teknisi datang tepat waktu, pengerjaannya rapi, dan AC langsung dingin semriwing.',
            ]
        );
    }
}
