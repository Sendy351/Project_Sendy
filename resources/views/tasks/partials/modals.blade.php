<!-- Modal 1: Buat Tugas Baru (Requester) -->
<div class="modal" id="createTaskModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-plus-circle" style="color: var(--primary);"></i> Buat Order Tugas Baru</h3>
            <button class="modal-close" onclick="closeModal('createTaskModal')">&times;</button>
        </div>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Kategori Bantuan</label>
                    <select name="category" class="form-control" required>
                        <option value="print_dokumen">Print Dokumen (Laporan/Makalah/Skripsi)</option>
                        <option value="titip_makanan">Titip Makanan (Kantin/Kopma/Warung Kampus)</option>
                        <option value="ambil_barang">Ambil Barang (Modul/Buku/Kunci/Paket)</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Judul Tugas (Singkat & Jelas)</label>
                    <input type="text" name="title" class="form-control" required placeholder="Contoh: Titip Print Laporan 10 Lbr di Lab Komputer Gedung C">
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Titik Penjemputan (Pickup)</label>
                        <input type="text" name="pickup_location" class="form-control" required placeholder="Contoh: Lab Komputer Lt. 2">
                    </div>
                    <div class="form-group">
                        <label>Titik Pengantaran (Drop-off)</label>
                        <input type="text" name="dropoff_location" class="form-control" required placeholder="Contoh: Gedung B Ruang 304">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Biaya Talangan Barang (Rp)</label>
                        <input type="number" name="item_price" class="form-control" value="0" min="0" placeholder="0 jika tidak ada barang yang dibeli">
                        <small style="color: #64748b; font-size: 0.75rem;">Contoh: harga cetak / harga makanan</small>
                    </div>
                    <div class="form-group">
                        <label>Ongkos Jasa / Tip Runner (Rp)</label>
                        <input type="number" name="tip_amount" class="form-control" value="5000" min="2000" step="1000" required>
                        <small style="color: #059669; font-size: 0.75rem; font-weight: 600;">Uang saku untuk teman yang membantu</small>
                    </div>
                </div>

                <div class="form-group">
                    <label>Instruksi / Catatan Tambahan</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Contoh: Tolong print warna, jilid lakban hitam. Saya tunggu sebelum jam 10 pagi ya."></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 12px; margin-top: 10px;">
                    <i class="fa-solid fa-paper-plane"></i> Posting ke Campus Feed
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Upload Bukti Selesai (Runner) -->
<div class="modal" id="proofModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-camera" style="color: var(--primary);"></i> Unggah Bukti Selesai</h3>
            <button class="modal-close" onclick="closeModal('proofModal')">&times;</button>
        </div>
        <form id="proofForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div style="background: #eff6ff; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                    <div style="font-weight: 700; color: #1e40af; font-size: 0.85rem;" id="proofTaskTitle">Judul Tugas</div>
                </div>

                <div class="form-group">
                    <label>Catatan Pengerjaan / Lokasi Serah Terima</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Sudah ditaruh di atas meja ketua kelas / sudah diserahkan langsung."></textarea>
                </div>

                <div class="form-group">
                    <label>Foto Bukti (Nota / Hasil Cetak / Serah Terima)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small style="color: #64748b; font-size: 0.75rem;">(Opsional) Foto membantu Requester memverifikasi tugasmu.</small>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 12px;">
                    <i class="fa-solid fa-check"></i> Kirim Bukti ke Requester
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 3: Konfirmasi Selesai & Beri Tip (Requester) -->
<div class="modal" id="completeModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-hand-holding-dollar" style="color: var(--emerald);"></i> Konfirmasi Selesai & Beri Tip</h3>
            <button class="modal-close" onclick="closeModal('completeModal')">&times;</button>
        </div>
        <form id="completeForm" method="POST">
            @csrf
            <div class="modal-body">
                <div style="background: #ecfdf5; border: 1px solid #a7f3d0; padding: 14px; border-radius: 8px; margin-bottom: 16px;">
                    <div style="font-size: 0.85rem; color: #065f46;" id="completeTaskTitle">Judul Tugas</div>
                    <div style="font-size: 1.3rem; font-weight: 800; color: #059669; margin-top: 4px;" id="completeTipVal">Rp 0</div>
                    <div style="font-size: 0.75rem; color: #047857;" id="completeRunnerName">Tip akan langsung ditransfer ke dompet Runner</div>
                </div>

                <div class="form-group">
                    <label>Rating untuk Runner</label>
                    <select name="rating" class="form-control" required>
                        <option value="5">★★★★★ (5/5) Sangat Cepat & Memuaskan</option>
                        <option value="4">★★★★☆ (4/5) Bagus & Tepat Waktu</option>
                        <option value="3">★★★☆☆ (3/5) Cukup Baik</option>
                        <option value="2">★★☆☆☆ (2/5) Kurang Memuaskan</option>
                        <option value="1">★☆☆☆☆ (1/5) Buruk</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ulasan / Komentar</label>
                    <textarea name="comment" class="form-control" rows="2" placeholder="Contoh: Cepat banget, tugas praktikum aman sebelum dosen masuk!"></textarea>
                </div>

                <button type="submit" class="btn btn-success" style="width: 100%; justify-content: center; padding: 12px;">
                    <i class="fa-solid fa-lock"></i> Konfirmasi & Cairkan Tip
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 4: Dompet Mahasiswa -->
<div class="modal" id="walletModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-wallet" style="color: var(--emerald);"></i> Dompet Mahasiswa</h3>
            <button class="modal-close" onclick="closeModal('walletModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 12px; margin-bottom: 20px;">
                <div style="font-size: 0.85rem; color: #64748b; font-weight: 600;">Saldo Uang Saku Saat Ini</div>
                <div style="font-size: 2rem; font-weight: 800; color: #059669;">
                    Rp {{ number_format(Auth::user()->wallet_balance, 0, ',', '.') }}
                </div>
                <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 4px;">
                    Akun: {{ Auth::user()->name }} ({{ Auth::user()->nim }})
                </div>
            </div>

            <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 12px;">Riwayat Mutasi Saldo:</h4>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                @forelse ($walletHistory as $history)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem;">
                        <div>
                            <div style="font-weight: 700; color: #1e293b;">{{ $history->description }}</div>
                            <div style="font-size: 0.7rem; color: #94a3b8;">{{ $history->created_at->diffForHumans() }}</div>
                        </div>
                        <div style="font-weight: 800; color: #059669;">
                            + Rp {{ number_format($history->amount, 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: #94a3b8; font-size: 0.85rem; padding: 20px;">
                        Belum ada riwayat transaksi dompet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openProofModal(taskId, title) {
        document.getElementById('proofTaskTitle').innerText = title;
        document.getElementById('proofForm').action = '/tasks/' + taskId + '/proof';
        openModal('proofModal');
    }

    function openCompleteModal(taskId, title, tipAmount, runnerName) {
        document.getElementById('completeTaskTitle').innerText = title;
        document.getElementById('completeTipVal').innerText = 'Rp ' + Number(tipAmount).toLocaleString('id-ID');
        document.getElementById('completeRunnerName').innerText = 'Tip akan langsung ditransfer ke dompet ' + runnerName;
        document.getElementById('completeForm').action = '/tasks/' + taskId + '/complete';
        openModal('completeModal');
    }
</script>
@endpush
