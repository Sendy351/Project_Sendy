<?php

namespace Database\Seeders;

use App\Models\OrderProof;
use App\Models\Review;
use App\Models\Task;
use App\Models\User;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Mahasiswa & Admin
        $users = [
            [
                'name' => 'Sendy Pratama',
                'email' => 'sendy@kampus.ac.id',
                'nim' => '22010101',
                'phone' => '081234567801',
                'role' => 'mahasiswa',
                'wallet_balance' => 35000.00,
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Tegar Setya Anggara',
                'email' => 'tegar@kampus.ac.id',
                'nim' => '22010102',
                'phone' => '081234567802',
                'role' => 'mahasiswa',
                'wallet_balance' => 50000.00,
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Dinda Putri Lestari',
                'email' => 'dinda@kampus.ac.id',
                'nim' => '22010103',
                'phone' => '081234567803',
                'role' => 'mahasiswa',
                'wallet_balance' => 15000.00,
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Reza Aditya',
                'email' => 'reza@kampus.ac.id',
                'nim' => '22010104',
                'phone' => '081234567804',
                'role' => 'mahasiswa',
                'wallet_balance' => 20000.00,
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Maya Safitri',
                'email' => 'maya@kampus.ac.id',
                'nim' => '22010105',
                'phone' => '081234567805',
                'role' => 'mahasiswa',
                'wallet_balance' => 0.00,
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Admin Kampus JasaKita',
                'email' => 'admin@jasakita.ac.id',
                'nim' => null,
                'phone' => '081200009999',
                'role' => 'admin',
                'wallet_balance' => 0.00,
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(['email' => $u['email']], $u);
        }

        $sendy = User::where('email', 'sendy@kampus.ac.id')->first();
        $tegar = User::where('email', 'tegar@kampus.ac.id')->first();
        $dinda = User::where('email', 'dinda@kampus.ac.id')->first();
        $reza  = User::where('email', 'reza@kampus.ac.id')->first();
        $maya  = User::where('email', 'maya@kampus.ac.id')->first();

        // 2. Tasks / Errands
        // Task 1: OPEN (Print Dokumen)
        Task::updateOrCreate(
            ['title' => 'Titip Print & Jilid Laporan Praktikum Jarkom (15 Hlm)'],
            [
                'requester_id' => $dinda->id,
                'runner_id' => null,
                'category' => 'print_dokumen',
                'description' => 'Print hitam putih 15 halaman, jilid klip mika bening biru. File PDF sudah dikirim via WhatsApp. Sangat mendesak sebelum kuliah jam 10!',
                'pickup_location' => 'Lab Komputer Lt. 2 (Gedung D)',
                'dropoff_location' => 'Gedung Kuliah Bersama B - Ruang 304',
                'item_price' => 7500.00,
                'tip_amount' => 5000.00,
                'status' => 'open',
            ]
        );

        // Task 2: OPEN (Titip Makanan)
        Task::updateOrCreate(
            ['title' => 'Titip Nasi Ayam Geprek Kantin Utama + Es Teh Manis'],
            [
                'requester_id' => $reza->id,
                'runner_id' => null,
                'category' => 'titip_makanan',
                'description' => 'Ayam geprek sambal bawang level 3 porsi nasi penuh di Stan Bu Siti, plus es teh manis jumbo. Lagi nugas perpus gabisa keluar.',
                'pickup_location' => 'Kantin Utama Kampus (Stan Bu Siti)',
                'dropoff_location' => 'Perpustakaan Pusat Lantai 2 (Meja Diskusi Belakang)',
                'item_price' => 18000.00,
                'tip_amount' => 7000.00,
                'status' => 'open',
            ]
        );

        // Task 3: TAKEN / IN_PROGRESS (Ambil Barang)
        Task::updateOrCreate(
            ['title' => 'Ambil Modul Praktikum Fisika Dasar yang Ketinggalan'],
            [
                'requester_id' => $sendy->id,
                'runner_id' => $tegar->id,
                'category' => 'ambil_barang',
                'description' => 'Buku modul warna hijau di meja satpam lobi Gedung Rektorat atas nama Sendy. Tolong bawa ke lab fisika sebelum praktikum dimulai.',
                'pickup_location' => 'Meja Satpam Lobi Gedung Rektorat',
                'dropoff_location' => 'Laboratorium Fisika Dasar Ruang 102',
                'item_price' => 0.00,
                'tip_amount' => 6000.00,
                'status' => 'in_progress',
                'taken_at' => Carbon::now()->subMinutes(20),
            ]
        );

        // Task 4: DELIVERED (Sudah diantar & ada bukti, menunggu konfirmasi)
        $task4 = Task::updateOrCreate(
            ['title' => 'Titip Beli Kertas Folio Bergaris & Materai 10.000 di Kopma'],
            [
                'requester_id' => $maya->id,
                'runner_id' => $sendy->id,
                'category' => 'ambil_barang',
                'description' => 'Beli kertas folio 1 pack kecil dan 1 lembar materai 10rb di Kopma untuk berkas pengajuan beasiswa.',
                'pickup_location' => 'Koperasi Mahasiswa (Kopma) Depan Gedung A',
                'dropoff_location' => 'Gedung Dekanat Fakultas Teknik Lt. 1',
                'item_price' => 15000.00,
                'tip_amount' => 5000.00,
                'status' => 'delivered',
                'taken_at' => Carbon::now()->subHours(1),
                'delivered_at' => Carbon::now()->subMinutes(10),
            ]
        );

        OrderProof::updateOrCreate(
            ['task_id' => $task4->id],
            [
                'runner_id' => $sendy->id,
                'image_path' => 'proofs/sample_nota_kopma.jpg',
                'notes' => 'Barang sudah dibelikan dan dititipkan ke meja resepsionis Dekanat ya kak.',
            ]
        );

        // Task 5: COMPLETED (Sudah selesai, tip cair ke dompet runner, ada rating)
        $task5 = Task::updateOrCreate(
            ['title' => 'Titip Print Makalah Seminar 25 Lembar Berwarna'],
            [
                'requester_id' => $tegar->id,
                'runner_id' => $reza->id,
                'category' => 'print_dokumen',
                'description' => 'Print makalah 25 lembar warna jilid lakban hitam. File di google drive.',
                'pickup_location' => 'Fotocopy & Print Center Dekat Parkiran Motor Barat',
                'dropoff_location' => 'Gedung Kuliah Bersama A Ruang 201',
                'item_price' => 25000.00,
                'tip_amount' => 10000.00,
                'status' => 'completed',
                'taken_at' => Carbon::now()->subDays(1)->setHour(13),
                'delivered_at' => Carbon::now()->subDays(1)->setHour(13)->setMinute(40),
                'completed_at' => Carbon::now()->subDays(1)->setHour(13)->setMinute(45),
            ]
        );

        OrderProof::updateOrCreate(
            ['task_id' => $task5->id],
            [
                'runner_id' => $reza->id,
                'image_path' => 'proofs/sample_print_makalah.jpg',
                'notes' => 'Makalah sudah diserahkan langsung di depan ruang 201.',
            ]
        );

        // Transaksi Dompet Masuk ke Runner
        WalletTransaction::updateOrCreate(
            [
                'user_id' => $reza->id,
                'task_id' => $task5->id,
            ],
            [
                'type' => 'credit',
                'amount' => 10000.00,
                'description' => 'Penerimaan Ongkos Jasa Runner: Task #' . $task5->id,
            ]
        );

        // Review dari Tegar ke Reza
        Review::updateOrCreate(
            [
                'task_id' => $task5->id,
                'reviewer_id' => $tegar->id,
            ],
            [
                'reviewee_id' => $reza->id,
                'rating' => 5,
                'comment' => 'Penyelamat banget! Pengantaran super kilat cuma 15 menit, tugas praktikum aman dikumpulkan tepat waktu.',
            ]
        );
    }
}
