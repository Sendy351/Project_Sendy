<?php

namespace Database\Seeders;

use App\Models\Jasa;
use App\Models\KategoriJasa;
use App\Models\Pembayaran;
use App\Models\Pengguna;
use App\Models\PenyediaJasa;
use App\Models\PermintaanJasa;
use App\Models\Pesanan;
use App\Models\Ulasan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class JasaKitaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pengguna Kampus
        $admin = Pengguna::updateOrCreate(
            ['email' => 'admin@jasakita.com'],
            [
                'nama' => 'Admin Kampus JasaKita',
                'kata_sandi' => Hash::make('password123'),
                'telepon' => '081234567890',
                'alamat' => 'Gedung Rektorat Lt. 2, Area Kampus',
                'peran' => 'admin',
            ]
        );

        $mhsPelanggan = Pengguna::updateOrCreate(
            ['email' => 'tegar@mahasiswa.ac.id'],
            [
                'nama' => 'Tegar Setya Anggara',
                'kata_sandi' => Hash::make('password123'),
                'telepon' => '085712345678',
                'alamat' => 'Kost Graha Mahasiswa Blok B No. 4, Dekat Gerbang Barat',
                'peran' => 'pelanggan',
            ]
        );

        $mhsPenyedia1 = Pengguna::updateOrCreate(
            ['email' => 'sendy@mahasiswa.ac.id'],
            [
                'nama' => 'Sendy Pratama',
                'kata_sandi' => Hash::make('password123'),
                'telepon' => '089876543210',
                'alamat' => 'Kost Sukamenak 14, Area Kampus',
                'peran' => 'penyedia',
            ]
        );

        $mhsPenyedia2 = Pengguna::updateOrCreate(
            ['email' => 'fikri.tech@mahasiswa.ac.id'],
            [
                'nama' => 'Fikri IT Solution',
                'kata_sandi' => Hash::make('password123'),
                'telepon' => '082198765432',
                'alamat' => 'Gedung Laboratorium Komputer Teknik',
                'peran' => 'penyedia',
            ]
        );

        // 2. Profil Penyedia Jasa Kampus
        $penyediaSendy = PenyediaJasa::updateOrCreate(
            ['pengguna_id' => $mhsPenyedia1->id],
            [
                'nama' => 'Sendy Express & Print Corner Kampus',
                'telepon' => '089876543210',
                'alamat' => 'Pusat Fotokopi & Kost Sukamenak Depan Kampus',
                'deskripsi' => 'Melayani print skripsi kilat, jilid hard/soft cover, titip beli makan kantin kampus, dan antar jemput dokumen/laundry area kampus.',
                'status' => 'aktif',
                'rating' => 4.95,
            ]
        );

        $penyediaFikri = PenyediaJasa::updateOrCreate(
            ['pengguna_id' => $mhsPenyedia2->id],
            [
                'nama' => 'Fikri IT & Tech Support Kampus',
                'telepon' => '082198765432',
                'alamat' => 'Sekretariat Himpunan Mahasiswa Informatika',
                'deskripsi' => 'Spesialis instal ulang Windows/Mac, software praktikum kuliah (MATLAB, SPSS, VS Code, Cisco), bersihkan debu laptop & ganti thermal paste.',
                'status' => 'aktif',
                'rating' => 4.90,
            ]
        );

        // 3. Kategori Jasa Khusus Lingkungan Kampus
        $katPrint = KategoriJasa::updateOrCreate(
            ['nama' => 'Print & Percetakan Dokumen'],
            [
                'deskripsi' => 'Print makalah, laporan praktikum, jilid lakban, soft cover & skripsi kilat.',
                'ikon' => 'print',
            ]
        );

        $katJastip = KategoriJasa::updateOrCreate(
            ['nama' => 'Jastip & Antar Barang Kampus'],
            [
                'deskripsi' => 'Titip beli makan siang kantin, ambil paket kurir di pos satpam, antar jemput laundry kost.',
                'ikon' => 'motorcycle',
            ]
        );

        $katLaptop = KategoriJasa::updateOrCreate(
            ['nama' => 'Servis Laptop & IT Kampus'],
            [
                'deskripsi' => 'Instalasi software kuliah praktikum, ganti thermal paste, perbaikan laptop lambat.',
                'ikon' => 'laptop-code',
            ]
        );

        $katAkademik = KategoriJasa::updateOrCreate(
            ['nama' => 'Bantuan Desain & Akademik'],
            [
                'deskripsi' => 'Bantuan desain slide presentasi PPT kuliah, poster tugas kuliah, dan olah data statistik.',
                'ikon' => 'chart-pie',
            ]
        );

        // 4. Layanan Jasa Kampus
        $jasaPrint = Jasa::updateOrCreate(
            ['nama' => 'Print & Jilid Laporan Praktikum / Makalah Kilat'],
            [
                'kategori_id' => $katPrint->id,
                'penyedia_id' => $penyediaSendy->id,
                'deskripsi' => "Print dokumen hitam putih / warna resolusi tinggi. Termasuk jilid mika bening rapi siap kumpul ke dosen. Bisa kirim file via PDF langsung cetak diantar ke kelas.",
                'harga' => 15000.00,
                'durasi' => '30 - 45 Menit',
                'gambar' => 'print_skripsi.jpg',
                'status' => 'aktif',
            ]
        );

        $jasaJastip = Jasa::updateOrCreate(
            ['nama' => 'Jasa Titip Beli Makan Siang Kantin & Antar ke Kelas/Kost'],
            [
                'kategori_id' => $katJastip->id,
                'penyedia_id' => $penyediaSendy->id,
                'deskripsi' => "Beli makanan di kantin kampus atau warung sekitar kampus (Geprek, Nasi Padang, Juice). Ongkos flat antar langsung ke gazebo/kelas/kost.",
                'harga' => 6000.00,
                'durasi' => '20 - 30 Menit',
                'gambar' => 'titip_makan.jpg',
                'status' => 'aktif',
            ]
        );

        $jasaAmbilPaket = Jasa::updateOrCreate(
            ['nama' => 'Ambil Paket Ekspedisi di Pos Satpam / Gerbang Kampus'],
            [
                'kategori_id' => $katJastip->id,
                'penyedia_id' => $penyediaSendy->id,
                'deskripsi' => "Pengambilan paket kurir Shopee/Tokopedia/J&T yang tertahan di pos satpam gerbang utama dan diantar ke gedung fakultas atau kost.",
                'harga' => 5000.00,
                'durasi' => '15 Menit',
                'gambar' => 'ambil_paket.jpg',
                'status' => 'aktif',
            ]
        );

        $jasaInstall = Jasa::updateOrCreate(
            ['nama' => 'Instal Ulang OS & Setup Software Praktikum Kuliah'],
            [
                'kategori_id' => $katLaptop->id,
                'penyedia_id' => $penyediaFikri->id,
                'deskripsi' => "Instal ulang Windows 10/11 bersih tanpa bloatware. Lengkap instalasi software kuliah: Office, PDF Reader, XAMPP, VS Code, Git, dan antivirus ringan.",
                'harga' => 60000.00,
                'durasi' => '2 - 3 Jam',
                'gambar' => 'laptop_service.jpg',
                'status' => 'aktif',
            ]
        );

        $jasaPpt = Jasa::updateOrCreate(
            ['nama' => 'Redesain Slide PPT Presentasi Tugas Kuliah Modern'],
            [
                'kategori_id' => $katAkademik->id,
                'penyedia_id' => $penyediaFikri->id,
                'deskripsi' => "Bikin slide presentasi PowerPoint / Canva tugas kuliah kamu jadi estetik, infografis modern, animasi transisi rapi dan siap tampil prima di depan dosen.",
                'harga' => 40000.00,
                'durasi' => '1 Hari',
                'gambar' => 'ppt_kuliah.jpg',
                'status' => 'aktif',
            ]
        );

        // 5. Permintaan Jasa
        $permintaan = PermintaanJasa::updateOrCreate(
            ['id' => 1],
            [
                'pengguna_id' => $mhsPelanggan->id,
                'jasa_id' => $jasaPrint->id,
                'penyedia_id' => $penyediaSendy->id,
                'deskripsi' => 'Print laporan praktikum modul 6 sebanyak 28 halaman full color cover mika biru.',
                'lokasi' => 'Gedung B Lt. 3 Ruang Lab Komputer 2',
                'jadwal' => now()->subHours(3),
                'status' => 'selesai',
                'total_harga' => 15000.00,
            ]
        );

        // 6. Pesanan
        $pesanan = Pesanan::updateOrCreate(
            ['id' => 1],
            [
                'permintaan_id' => $permintaan->id,
                'penyedia_id' => $penyediaSendy->id,
                'pengguna_id' => $mhsPelanggan->id,
                'status' => 'selesai',
                'diterima_pada' => now()->subHours(3),
                'dimulai_pada' => now()->subHours(2)->subMinutes(30),
                'selesai_pada' => now()->subHours(2),
                'total_harga' => 15000.00,
            ]
        );

        // 7. Pembayaran
        Pembayaran::updateOrCreate(
            ['pesanan_id' => $pesanan->id],
            [
                'metode' => 'qris',
                'jumlah' => 15000.00,
                'status' => 'berhasil',
                'tanggal_pembayaran' => now()->subHours(2),
            ]
        );

        // 8. Ulasan
        Ulasan::updateOrCreate(
            ['pesanan_id' => $pesanan->id],
            [
                'pengguna_id' => $mhsPelanggan->id,
                'penyedia_id' => $penyediaSendy->id,
                'rating' => 5,
                'komentar' => 'Hasil cetak sangat tajam dan jilidnya super rapi. Diantar tepat waktu sebelum kelas dimulai!',
            ]
        );
    }
}
