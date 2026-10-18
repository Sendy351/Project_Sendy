<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jasa_Kita - Live Demo & Dashboard Presentasi UTS Backend</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-base: #0B0F19;
            --bg-surface: #111827;
            --bg-card: #1F2937;
            --border: #374151;
            --primary: #3B82F6;
            --primary-hover: #2563EB;
            --accent: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --text-main: #F9FAFB;
            --text-muted: #9CA3AF;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-base);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: rgba(17, 24, 39, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 50;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .badge-live {
            background: rgba(16, 185, 129, 0.15);
            color: var(--accent);
            border: 1px solid var(--accent);
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-live::before {
            content: '';
            width: 8px;
            height: 8px;
            background: var(--accent);
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.9); opacity: 0.7; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(0.9); opacity: 0.7; }
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem;
            flex: 1;
            width: 100%;
        }

        .grid-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.25rem;
            transition: transform 0.2s, border-color 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: var(--primary);
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-val {
            font-size: 1.85rem;
            font-weight: 800;
            margin-top: 0.5rem;
            color: #60A5FA;
        }

        .tabs {
            display: flex;
            gap: 8px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 1.5rem;
        }

        .tab-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            padding: 0.75rem 1.25rem;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }

        .tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .panel {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(55, 65, 81, 0.5);
        }

        th {
            background: rgba(31, 41, 55, 0.5);
            color: var(--text-muted);
            font-weight: 600;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn:hover {
            background: var(--primary-hover);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-main);
        }

        .btn-outline:hover {
            background: var(--bg-card);
            border-color: var(--primary);
        }

        .code-box {
            background: #030712;
            border: 1px solid #1F2937;
            border-radius: 8px;
            padding: 1rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            color: #10B981;
            max-height: 350px;
            overflow-y: auto;
            white-space: pre-wrap;
        }

        .slide-card {
            background: #1E293B;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .slide-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            border-bottom: 1px solid #334155;
            padding-bottom: 0.75rem;
        }

        .slide-badge {
            background: #3B82F6;
            color: white;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <header>
        <div class="brand">
            <h2 style="font-size: 1.25rem; font-weight: 800; color: #FFFFFF;">Jasa_Kita <span style="font-weight: 400; color: #9CA3AF; font-size: 0.95rem;">| Backend API & DB Design</span></h2>
            <span class="badge-live">DATABASE AKTIF (MySQL)</span>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="/JasaKita_API_Postman_Collection.json" download class="btn btn-outline">📥 Unduh Postman Collection</a>
            <a href="/api/jasa" target="_blank" class="btn">🚀 Test /api/jasa</a>
        </div>
    </header>

    <div class="container">
        <!-- Stats Row -->
        <div class="grid-stats">
            <div class="stat-card">
                <div class="stat-label">Pengguna Terdaftar</div>
                <div class="stat-val">{{ $stats['pengguna'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Penyedia Jasa</div>
                <div class="stat-val">{{ $stats['penyedia'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Katalog Jasa Aktif</div>
                <div class="stat-val">{{ $stats['jasa'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-val">{{ $stats['pesanan'] }}</div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="tabs">
            <button class="tab-btn active" onclick="switchTab('tab-slides')">📊 Materi Presentasi UTS (Slide 1 - 9)</button>
            <button class="tab-btn" onclick="switchTab('tab-tester')">⚡ Live API Endpoint Tester</button>
            <button class="tab-btn" onclick="switchTab('tab-erd')">🗺️ Skema ERD & Relasi Tabel</button>
            <button class="tab-btn" onclick="switchTab('tab-data')">📂 Data Database Real-Time</button>
        </div>

        <!-- TAB 1: PRESENTASI UTS -->
        <div id="tab-slides" class="tab-content active">
            <div class="panel">
                <h3 style="margin-bottom: 0.5rem;">Dokumen Panduan Presentasi Progress UTS</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">
                    Format & unsur telah disesuaikan 100% dengan Template Presentasi UTS Mata Kuliah <strong>Project Database Backend (Laravel & Database Design)</strong>.
                </p>

                <!-- Slide 1 -->
                <div class="slide-card">
                    <div class="slide-header">
                        <h4>Slide 1: Judul & Identitas Kelompok (Estimasi: 1 Menit)</h4>
                        <span class="slide-badge">SLIDE 1</span>
                    </div>
                    <ul style="margin-left: 1.25rem; color: #CBD5E1; line-height: 1.7; font-size: 0.9rem;">
                        <li><strong>Nama Project Backend:</strong> Jasa_Kita (Sistem Informasi Permintaan dan Penyediaan Jasa Multifungsi Berbasis Web)</li>
                        <li><strong>Mata Kuliah:</strong> Project Database Backend (Laravel 12 & MySQL)</li>
                        <li><strong>Nama & NIM Anggota Kelompok:</strong>
                            <ul style="margin-left: 1rem; color: #94A3B8;">
                                <li>Tegar Setya Anggara - <strong>Lead Database & Backend Architect</strong> (Perancangan ERD, Normalisasi, Database Migration & Indexing)</li>
                                <li>Sendy Pratama - <strong>Laravel Developer</strong> (Eloquent ORM Relations, Seeder/Factory, Middleware & Lifecycle)</li>
                                <li>Anggota 3 / Partner - <strong>API Developer & QA</strong> (RESTful Endpoints, Postman Documentation, HTTP Testing)</li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <!-- Slide 2 -->
                <div class="slide-card">
                    <div class="slide-header">
                        <h4>Slide 2: Gantt Chart & Tugas Pokok PIC</h4>
                        <span class="slide-badge">SLIDE 2</span>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Fase Proyek</th>
                                    <th>Aktivitas Utama</th>
                                    <th>PIC</th>
                                    <th>Minggu 1-2</th>
                                    <th>Minggu 3-4</th>
                                    <th>Minggu 5-7 (UTS)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Fase 1: Database Design</td>
                                    <td>Analisis Studi Kasus, ERD 8 Entitas, Normalisasi 1NF-3NF</td>
                                    <td>Lead DB</td>
                                    <td style="color: #10B981;">✔ Selesai</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Fase 2: Laravel Migration</td>
                                    <td>Migration 8 Tabel, Foreign Keys, Indexing, Database Seeder</td>
                                    <td>Laravel Dev</td>
                                    <td>-</td>
                                    <td style="color: #10B981;">✔ Selesai</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Fase 3: Eloquent & REST API</td>
                                    <td>Model Relasi 1-to-1, 1-to-N, 23 Endpoints RESTful, Postman Test</td>
                                    <td>API Dev & Tim</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td style="color: #10B981;">✔ Selesai (Progress 100% UTS)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="slide-card">
                    <div class="slide-header">
                        <h4>Slide 3: Ruang Lingkup & Gambaran Sistem (Estimasi: 1 - 2 Menit)</h4>
                        <span class="slide-badge">SLIDE 3</span>
                    </div>
                    <ul style="margin-left: 1.25rem; color: #CBD5E1; line-height: 1.7; font-size: 0.9rem;">
                        <li><strong>Latar Belakang:</strong> Kebutuhan platform terpercaya untuk menjembatani pelanggan rumah tangga dengan penyedia jasa teknis lokal (servis AC, kelistrikan, daily cleaning) secara transparan dan terstandarisasi.</li>
                        <li><strong>Kebutuhan Bisnis:</strong> Katalog jasa transparan, alur booking permintaan jasa yang terstruktur, konfirmasi pesanan, pencatatan pembayaran terintegrasi, dan penilaian rating/ulasan terverifikasi.</li>
                        <li><strong>Batasan Backend:</strong> Sistem backend mengelola 8 entitas inti data relasional, REST API JSON, validasi request server-side, dan Eloquent ORM.</li>
                    </ul>
                </div>

                <!-- Slide 4 -->
                <div class="slide-card">
                    <div class="slide-header">
                        <h4>Slide 4: Perancangan Database (Estimasi: 3 Menit)</h4>
                        <span class="slide-badge">SLIDE 4</span>
                    </div>
                    <ul style="margin-left: 1.25rem; color: #CBD5E1; line-height: 1.7; font-size: 0.9rem;">
                        <li><strong>8 Entitas ERD:</strong> <code>pengguna</code>, <code>penyedia_jasa</code>, <code>kategori_jasa</code>, <code>jasa</code>, <code>permintaan_jasa</code>, <code>pesanan</code>, <code>pembayaran</code>, <code>ulasan</code>.</li>
                        <li><strong>Primary & Foreign Keys:</strong> Semua tabel memakai BigInteger Auto-Increment PK, dan Foreign Key berindeks dengan constraint referential integrity (<code>ON DELETE CASCADE</code>).</li>
                        <li><strong>Normalisasi:</strong>
                            <ul style="margin-left: 1rem; color: #94A3B8;">
                                <li><strong>1NF:</strong> Semua kolom bersifat atomik (tidak ada multivalue/repeating group).</li>
                                <li><strong>2NF:</strong> Seluruh non-key attribute bergantung penuh pada Primary Key tunggal.</li>
                                <li><strong>3NF:</strong> Tidak ada ketergantungan transitif; profil penyedia dan kategori dipisahkan menjadi tabel mandiri.</li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <!-- Slide 5 -->
                <div class="slide-card">
                    <div class="slide-header">
                        <h4>Slide 5: Implementasi Database di Laravel (Estimasi: 2 - 3 Menit)</h4>
                        <span class="slide-badge">SLIDE 5</span>
                    </div>
                    <ul style="margin-left: 1.25rem; color: #CBD5E1; line-height: 1.7; font-size: 0.9rem;">
                        <li><strong>Database Migration:</strong> 8 file migration terurut mengeksekusi pembuatan tabel dengan timestamp kustom (<code>dibuat_pada</code>, <code>diperbarui_pada</code>).</li>
                        <li><strong>Database Seeder:</strong> <code>JasaKitaSeeder.php</code> mengisi data master relasional (Admin, Pelanggan, Penyedia, Kategori, Jasa, Booking, Pesanan, Pembayaran, Ulasan).</li>
                        <li><strong>Relasi Eloquent ORM:</strong>
                            <ul style="margin-left: 1rem; color: #94A3B8;">
                                <li><strong>1-to-1:</strong> <code>Pengguna -> hasOne(PenyediaJasa)</code>, <code>Pesanan -> hasOne(Pembayaran)</code>, <code>PermintaanJasa -> hasOne(Pesanan)</code>.</li>
                                <li><strong>1-to-N:</strong> <code>KategoriJasa -> hasMany(Jasa)</code>, <code>PenyediaJasa -> hasMany(Jasa)</code>, <code>Pesanan -> hasMany(Ulasan)</code>.</li>
                                <li><strong>Indexing:</strong> Index otomatis pada foreign keys (<code>pengguna_id</code>, <code>penyedia_id</code>, <code>kategori_id</code>, <code>jasa_id</code>, <code>pesanan_id</code>) untuk efisiensi join query.</li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <!-- Slide 7 -->
                <div class="slide-card">
                    <div class="slide-header">
                        <h4>Slide 7: Capaian Fitur & Demo Backend (Estimasi: 4 - 5 Menit)</h4>
                        <span class="slide-badge">SLIDE 7</span>
                    </div>
                    <p style="color: #CBD5E1; font-size: 0.9rem; margin-bottom: 0.75rem;">
                        <strong>Status: 23 Endpoints REST API Selesai 100% dan Siap Diuji.</strong>
                    </p>
                    <div style="display: flex; gap: 10px; margin-bottom: 1rem;">
                        <a href="/JasaKita_API_Postman_Collection.json" download class="btn">📥 Download Postman Collection (v2.1)</a>
                        <button onclick="switchTab('tab-tester')" class="btn btn-outline">⚡ Buka Live Tester Tab</button>
                    </div>
                </div>

                <!-- Slide 8 -->
                <div class="slide-card">
                    <div class="slide-header">
                        <h4>Slide 8: Kendala & Belum Dikerjakan (Backlog Menuju UAS)</h4>
                        <span class="slide-badge">SLIDE 8</span>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item Backlog</th>
                                    <th>Deskripsi Kendala / Rencana Aksi</th>
                                    <th>Target Penyelesaian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Payment Gateway Integration</td>
                                    <td>Saat ini pembayaran simulasi REST API. Menuju UAS akan diintegrasikan dengan Midtrans/Xendit Sandbox.</td>
                                    <td>Fase UAS (Minggu 11)</td>
                                </tr>
                                <tr>
                                    <td>Real-time Tracking & Notifikasi</td>
                                    <td>Integrasi Laravel Reverb / Pusher untuk pembaruan status pesanan real-time ke pelanggan.</td>
                                    <td>Fase UAS (Minggu 13)</td>
                                </tr>
                                <tr>
                                    <td>Role-Based Access Control (RBAC)</td>
                                    <td>Penyempurnaan middleware otorisasi multi-role (Admin vs Penyedia vs Pelanggan) dengan Laravel Sanctum Token.</td>
                                    <td>Fase UAS (Minggu 12)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Slide 9 -->
                <div class="slide-card">
                    <div class="slide-header">
                        <h4>Slide 9: Kesimpulan & Q&A (Estimasi: 3 - 5 Menit)</h4>
                        <span class="slide-badge">SLIDE 9</span>
                    </div>
                    <ul style="margin-left: 1.25rem; color: #CBD5E1; line-height: 1.7; font-size: 0.9rem;">
                        <li><strong>Tingkat Ketercapaian Progress UTS:</strong> <strong>100% dari Target Milestone UTS</strong> (Skema ERD 8 tabel, Migration, Seeder, Eloquent Relations, dan 23 Endpoint RESTful API).</li>
                        <li><strong>Kesiapan:</strong> Sistem siap didemonstrasikan langsung melalui Postman maupun web inspector. Sesi tanya jawab teknis dibuka untuk Dosen dan audiens.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- TAB 2: LIVE API TESTER -->
        <div id="tab-tester" class="tab-content">
            <div class="panel">
                <h3 style="margin-bottom: 0.5rem;">Interactive REST API Tester</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">
                    Klik tombol di bawah untuk langsung mengeksekusi endpoint API backend secara live dan melihat respons JSON:
                </p>

                <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 1.5rem;">
                    <button class="btn btn-outline" onclick="testEndpoint('/api/jasa')">GET /api/jasa</button>
                    <button class="btn btn-outline" onclick="testEndpoint('/api/kategori-jasa')">GET /api/kategori-jasa</button>
                    <button class="btn btn-outline" onclick="testEndpoint('/api/penyedia-jasa')">GET /api/penyedia-jasa</button>
                    <button class="btn btn-outline" onclick="testEndpoint('/api/permintaan-jasa')">GET /api/permintaan-jasa</button>
                    <button class="btn btn-outline" onclick="testEndpoint('/api/pesanan')">GET /api/pesanan</button>
                    <button class="btn btn-outline" onclick="testEndpoint('/api/ulasan')">GET /api/ulasan</button>
                </div>

                <div style="margin-bottom: 0.5rem; display: flex; justify-content: space-between;">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Endpoint Saat Ini: <strong id="endpoint-url" style="color: #60A5FA;">/api/jasa</strong></span>
                    <span id="endpoint-status" style="font-size: 0.85rem; color: #10B981; font-weight: 700;">STATUS: 200 OK</span>
                </div>
                <div class="code-box" id="json-output">Memuat data...</div>
            </div>
        </div>

        <!-- TAB 3: SKEMA ERD -->
        <div id="tab-erd" class="tab-content">
            <div class="panel">
                <h3 style="margin-bottom: 1rem;">Entity Relationship Diagram (ERD) - 8 Tabel</h3>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Tabel</th>
                                <th>Primary Key</th>
                                <th>Foreign Keys</th>
                                <th>Atribut Utama</th>
                                <th>Relasi / Kardinalitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>pengguna</code></td>
                                <td>id</td>
                                <td>-</td>
                                <td>nama, email, kata_sandi, telepon, alamat, peran</td>
                                <td>1 ke 0..1 ke <code>penyedia_jasa</code>, 1 ke N ke <code>permintaan_jasa</code></td>
                            </tr>
                            <tr>
                                <td><code>penyedia_jasa</code></td>
                                <td>id</td>
                                <td>pengguna_id</td>
                                <td>nama, telepon, alamat, deskripsi, status, rating</td>
                                <td>1 ke N ke <code>jasa</code></td>
                            </tr>
                            <tr>
                                <td><code>kategori_jasa</code></td>
                                <td>id</td>
                                <td>-</td>
                                <td>nama, deskripsi, ikon</td>
                                <td>1 ke N ke <code>jasa</code></td>
                            </tr>
                            <tr>
                                <td><code>jasa</code></td>
                                <td>id</td>
                                <td>kategori_id, penyedia_id</td>
                                <td>nama, deskripsi, harga, durasi, gambar, status</td>
                                <td>N ke 1 ke <code>kategori_jasa</code>, N ke 1 ke <code>penyedia_jasa</code></td>
                            </tr>
                            <tr>
                                <td><code>permintaan_jasa</code></td>
                                <td>id</td>
                                <td>pengguna_id, jasa_id, penyedia_id</td>
                                <td>deskripsi, lokasi, jadwal, status, total_harga</td>
                                <td>N ke 1 ke <code>pesanan</code></td>
                            </tr>
                            <tr>
                                <td><code>pesanan</code></td>
                                <td>id</td>
                                <td>permintaan_id, penyedia_id, pengguna_id</td>
                                <td>status, diterima_pada, dimulai_pada, selesai_pada, total_harga</td>
                                <td>1 ke 0..1 ke <code>pembayaran</code>, 1 ke 0..N ke <code>ulasan</code></td>
                            </tr>
                            <tr>
                                <td><code>pembayaran</code></td>
                                <td>id</td>
                                <td>pesanan_id</td>
                                <td>metode, jumlah, status, tanggal_pembayaran</td>
                                <td>N ke 1 ke <code>pesanan</code></td>
                            </tr>
                            <tr>
                                <td><code>ulasan</code></td>
                                <td>id</td>
                                <td>pesanan_id, pengguna_id, penyedia_id</td>
                                <td>rating (1-5), komentar</td>
                                <td>N ke 1 ke <code>pesanan</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 4: DATABASE REAL-TIME -->
        <div id="tab-data" class="tab-content">
            <div class="panel">
                <h3 style="margin-bottom: 1rem;">Data Jasa & Layanan di Database</h3>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kategori</th>
                                <th>Nama Layanan</th>
                                <th>Penyedia</th>
                                <th>Harga</th>
                                <th>Durasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jasaList as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td><span style="background: rgba(59, 130, 246, 0.2); color: #93C5FD; padding: 2px 8px; border-radius: 4px;">{{ $item->kategori->nama ?? '-' }}</span></td>
                                    <td><strong>{{ $item->nama }}</strong></td>
                                    <td>{{ $item->penyedia->nama ?? '-' }}</td>
                                    <td style="color: #34D399; font-weight: 700;">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->durasi }}</td>
                                    <td><span style="color: #10B981;">{{ strtoupper($item->status) }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">Belum ada data jasa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabId) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            event.target.classList.add('active');
            document.getElementById(tabId).classList.add('active');

            if (tabId === 'tab-tester') {
                testEndpoint('/api/jasa');
            }
        }

        function testEndpoint(url) {
            document.getElementById('endpoint-url').innerText = url;
            document.getElementById('endpoint-status').innerText = 'LOADING...';
            document.getElementById('json-output').innerText = 'Mengirim request ke ' + url + '...';

            fetch(url)
                .then(res => {
                    document.getElementById('endpoint-status').innerText = 'STATUS: ' + res.status + ' ' + res.statusText;
                    return res.json();
                })
                .then(data => {
                    document.getElementById('json-output').innerText = JSON.stringify(data, null, 2);
                })
                .catch(err => {
                    document.getElementById('endpoint-status').innerText = 'ERROR';
                    document.getElementById('json-output').innerText = err.toString();
                });
        }
    </script>
</body>
</html>
