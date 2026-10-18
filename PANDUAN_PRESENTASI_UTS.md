# PANDUAN LENGKAP & MATERI PRESENTASI PROGRESS UTS
**Mata Kuliah:** Project Database Backend (Laravel & Database Design)  
**Nama Sistem Backend:** Jasa_Kita (Sistem Informasi Permintaan dan Penyediaan Jasa Multifungsi Berbasis Web)  
**Database:** MySQL (Database: `Jasa_Kita`)  
**Framework:** Laravel 12 (PHP 8.2+)  

---

## 📌 SLIDE 1: JUDUL & IDENTITAS KELOMPOK
- **Estimasi Waktu:** 1 Menit
- **Output / Artifact:** Slide Cover / Tim
- **Konten Presentasi:**
  - **Judul Proyek:** *Sistem Informasi Permintaan dan Penyediaan Jasa Multifungsi Berbasis Web (Jasa_Kita)*
  - **Studi Kasus:** Marketplace penyediaan layanan rumah tangga dan teknis terstandarisasi.
  - **Susunan Tim & Pembagian Tugas (Role):**
    1. **Tegar Setya Anggara** – *Lead Database & System Architect*  
       *(Tanggung Jawab: Perancangan ERD, Relasi Tabel, Normalisasi 1NF-3NF, Database Migration, Foreign Key Constraints & Indexing)*
    2. **Sendy Pratama** – *Laravel Backend Developer*  
       *(Tanggung Jawab: Eloquent ORM Modeling, Custom Timestamps, Database Seeder relasional, Logic Workflow Pesanan)*
    3. **Anggota Tim 3** – *API Developer & QA Tester*  
       *(Tanggung Jawab: Pembuatan 23 Endpoints REST API JSON, Validasi Request, Postman Collection & Pengujian HTTP)*

---

## 📌 SLIDE 2: GANTT CHART (JADWAL & TUGAS POKOK PIC)
- **Tugas Pokok Masing-masing PIC:**

| Aktivitas Pokok | PIC | Minggu 1-2 | Minggu 3-4 | Minggu 5-7 (UTS) | Status |
| :--- | :--- | :---: | :---: | :---: | :---: |
| Analisis Kebutuhan & Desain ERD (8 Entitas) | Lead DB | █ | | | **100% Selesai** |
| Normalisasi Database & Skema Relasi | Lead DB | █ | | | **100% Selesai** |
| Implementasi Migration & Indexing Laravel | Laravel Dev | | █ | | **100% Selesai** |
| Pembuatan Database Seeder Relasional | Laravel Dev | | █ | | **100% Selesai** |
| Eloquent Model & Relasi (1-to-1, 1-to-N) | Laravel Dev | | █ | █ | **100% Selesai** |
| Pengembangan 23 REST API Endpoints | API Dev | | | █ | **100% Selesai** |
| Pengujian HTTP Request via Postman & Live Demo | Tim | | | █ | **100% Selesai** |

---

## 📌 SLIDE 3: RUANG LINGKUP & GAMBARAN SISTEM
- **Estimasi Waktu:** 1 - 2 Menit
- **Output / Artifact:** Diagram Ringkasan Fitur / Scope
- **Poin Wajib Dimuat:**
  1. **Latar Belakang:** Banyak masyarakat mengalami kesulitan menemukan tenaga jasa panggilan (seperti tukang servis AC, kelistrikan, daily cleaning) yang memiliki tarif transparan dan reputasi terpercaya.
  2. **Kebutuhan Bisnis:** 
     - Menghubungkan pengguna (pelanggan) dengan penyedia jasa terverifikasi.
     - Menyediakan katalog jasa dengan rincian harga, estimasi durasi, dan kategori.
     - Alur booking jasa yang runtut: *Permintaan Jasa -> Pesanan Diterima -> Dikerjakan -> Selesai -> Pembayaran -> Rating & Review*.
  3. **Batasan Ruang Lingkup Backend (UTS Scope):**
     - Mengelola 8 entitas relasional inti sesuai ERD.
     - Menyediakan API berbasis JSON untuk seluruh siklus transaksi.
     - Validasi request di sisi server (*server-side input validation*).

---

## 📌 SLIDE 4: PERANCANGAN DATABASE
- **Estimasi Waktu:** 3 Menit
- **Output / Artifact:** Gambar ERD & Relasi Tabel
- **Poin Wajib Dimuat:**
  - **Entity Relationship Diagram (8 Entitas):**
    1. `pengguna`: PK `id`, nama, email (unik), kata_sandi, telepon, alamat, peran.
    2. `penyedia_jasa`: PK `id`, FK `pengguna_id` (unik), nama, telepon, alamat, deskripsi, status, rating.
    3. `kategori_jasa`: PK `id`, nama, deskripsi, ikon.
    4. `jasa`: PK `id`, FK `kategori_id`, FK `penyedia_id`, nama, deskripsi, harga, durasi, gambar, status.
    5. `permintaan_jasa`: PK `id`, FK `pengguna_id`, FK `jasa_id`, FK `penyedia_id`, deskripsi, lokasi, jadwal, status, total_harga.
    6. `pesanan`: PK `id`, FK `permintaan_id`, FK `penyedia_id`, FK `pengguna_id`, status, diterima_pada, dimulai_pada, selesai_pada, total_harga.
    7. `pembayaran`: PK `id`, FK `pesanan_id`, metode, jumlah, status, tanggal_pembayaran.
    8. `ulasan`: PK `id`, FK `pesanan_id`, FK `pengguna_id`, FK `penyedia_id`, rating (1-5), komentar.
  - **Normalisasi Database:**
    - **1NF:** Seluruh atribut bersifat atomik, tidak ada composite attribute maupun multi-valued attribute.
    - **2NF:** Seluruh tabel menggunakan Single Primary Key (`id`), sehingga tidak ada ketergantungan parsial (*partial functional dependency*).
    - **3NF:** Atribut non-key hanya bergantung langsung pada primary key tabel bersangkutan; atribut profil penyedia dan kategori dinormalisasi ke entitas tersendiri sehingga bebas dari ketergantungan transitif (*transitive dependency*).

---

## 📌 SLIDE 5: IMPLEMENTASI DATABASE DI LARAVEL
- **Estimasi Waktu:** 2 - 3 Menit
- **Output / Artifact:** Screenshot Kode Migration & Model Eloquent
- **Poin Wajib Dimuat:**
  - **Database Migration:** 
    - 8 migration files diurutkan secara hierarkis untuk menghindari foreign key violation.
    - Menggunakan kolom timestamp Bahasa Indonesia:
      ```php
      const CREATED_AT = 'dibuat_pada';
      const UPDATED_AT = 'diperbarui_pada';
      ```
  - **Database Seeder:**
    - `JasaKitaSeeder.php` mengisi data riil berelasi (Pengguna, Penyedia, Kategori, Jasa, Permintaan, Pesanan, Pembayaran, dan Ulasan).
  - **Relasi Eloquent ORM:**
    - **1-to-1:** 
      - `Pengguna::hasOne(PenyediaJasa::class, 'pengguna_id')`
      - `Pesanan::hasOne(Pembayaran::class, 'pesanan_id')`
    - **1-to-N:** 
      - `KategoriJasa::hasMany(Jasa::class, 'kategori_id')`
      - `PenyediaJasa::hasMany(Jasa::class, 'penyedia_id')`
      - `Pesanan::hasMany(Ulasan::class, 'pesanan_id')`
  - **Indexing:**
    - Index otomatis pada semua foreign keys untuk mengoptimalkan performa query *join* dan *eager loading*.

---

## 📌 SLIDE 7: CAPAIAN FITUR & DEMO BACKEND
- **Estimasi Waktu:** 4 - 5 Menit
- **Output / Artifact:** Live Demo & Postman Collection Result
- **Daftar 23 Endpoint API yang Telah Selesai:**
  1. `POST /api/auth/register` (Registrasi Pengguna)
  2. `POST /api/auth/login` (Login Pengguna)
  3. `GET  /api/auth/profile/{id}` (Profil Pengguna)
  4. `GET  /api/kategori-jasa` (List Kategori)
  5. `GET  /api/kategori-jasa/{id}` (Detail Kategori & Jasanya)
  6. `POST /api/kategori-jasa` (Tambah Kategori)
  7. `GET  /api/penyedia-jasa` (List Penyedia Jasa)
  8. `GET  /api/penyedia-jasa/{id}` (Detail Penyedia, Rating & Review)
  9. `POST /api/penyedia-jasa` (Registrasi Profil Penyedia)
  10. `GET  /api/jasa` (Katalog Jasa & Filter)
  11. `GET  /api/jasa/{id}` (Detail Jasa Lengkap)
  12. `POST /api/jasa` (Tambah Layanan Jasa)
  13. `GET  /api/permintaan-jasa` (Riwayat Permintaan Booking)
  14. `POST /api/permintaan-jasa` (Ajukan Permintaan Jasa)
  15. `GET  /api/permintaan-jasa/{id}` (Detail Permintaan)
  16. `GET  /api/pesanan` (List Pesanan)
  17. `POST /api/pesanan` (Proses Permintaan Jadi Pesanan)
  18. `GET  /api/pesanan/{id}` (Detail Pesanan & Tracking)
  19. `PATCH /api/pesanan/{id}/status` (Update Status: diterima/dimulai/selesai)
  20. `POST /api/pembayaran` (Pembayaran Pesanan)
  21. `GET  /api/pembayaran/{id}` (Status Pembayaran)
  22. `POST /api/ulasan` (Kirim Rating & Ulasan)
  23. `GET  /api/ulasan` (List Ulasan & Feedback)
- **Artifact yang Disertakan:** File `JasaKita_API_Postman_Collection.json` yang dapat di-import langsung di Postman oleh dosen/penguji.

---

## 📌 SLIDE 8: KENDALA & BELUM DIKERJAKAN (BACKLOG MENUJU UAS)
- **Estimasi Waktu:** 2 Menit
- **Output / Artifact:** Tabel Feature Backlog & Roadmap UAS

| Feature Backlog | Kendala Teknis Saat Ini | Rencana Aksi Menuju UAS |
| :--- | :--- | :--- |
| **Integrasi Payment Gateway Real** | Pembayaran saat ini berupa simulasi REST API transaksi berhasil. | Integrasi Webhook & SDK Midtrans/Xendit Sandbox untuk menerima QRIS dan VA Bank otomatis. |
| **Websocket / Real-time Notification** | Status pesanan masih diakses lewat polling HTTP GET. | Mengimplementasikan Laravel Reverb / Pusher untuk pembaruan status pengerjaan secara real-time. |
| **Token-Based Auth & RBAC** | Otentikasi berbasis session & basic hash. | Penerapan Laravel Sanctum Bearer Token dengan middleware otorisasi per-peran (Admin, Penyedia, Pelanggan). |

---

## 📌 SLIDE 9: KESIMPULAN & Q&A
- **Estimasi Waktu:** 3 - 5 Menit
- **Output / Artifact:** Slide Penutup & Sesi Diskusi
- **Rangkuman Progress:**
  - **Tingkat Ketercapaian Progress UTS: 100%** terhadap seluruh kriteria penilaian database backend (Perancangan ERD, Normalisasi, Migration, Seeder, Eloquent Model, 23 REST API Endpoints, dan Postman Collection).
  - Sistem telah teruji dan siap dilanjutkan ke tahap integrasi frontend & payment gateway pada fase menuju UAS.
- **Sesi Tanya Jawab (Q&A):** Membuka sesi diskusi dengan dosen pengampu dan rekan-rekan mahasiswa.
