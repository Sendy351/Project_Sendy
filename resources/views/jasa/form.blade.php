@extends('layouts.jasakita')

@section('title', ($isEdit ? 'Edit Layanan Jasa' : 'Tambah Layanan Jasa Baru') . ' - JasaKita')

@section('content')
<div style="max-width: 680px; margin: 1.5rem auto;">
    <div style="margin-bottom: 1.25rem;">
        <a href="{{ route('jasa.index') }}" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Batal & Kembali
        </a>
    </div>

    <div class="card" style="padding: 2.25rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 16px; box-shadow: var(--shadow-md);">
        <div style="margin-bottom: 1.75rem;">
            <span style="background: var(--primary-light); color: var(--primary); font-size: 0.75rem; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
                LAYANAN MAHASISWA & MITRA KAMPUS
            </span>
            <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-top: 8px;">
                {{ $isEdit ? 'Perbarui Informasi Layanan' : 'Buka Layanan Jasa Baru di Kampus' }}
            </h2>
            <p style="color: var(--text-muted); font-size: 0.85rem;">Tentukan tarif terjangkau dan estimasi waktu yang jelas untuk mempermudah rekan mahasiswa.</p>
        </div>

        <form action="{{ $isEdit ? route('jasa.update', $jasa->id) : route('jasa.store') }}" method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">
                    Kategori Layanan
                </label>
                <select name="kategori_id" aria-label="Kategori" required 
                    style="width: 100%; padding: 0.75rem 1rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none;">
                    <option value="">-- Pilih Kategori Kampus --</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat->id }}" {{ old('kategori_id', $jasa->kategori_id) == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">
                    Nama Layanan Jasa
                </label>
                <input type="text" name="nama" aria-label="Nama" value="{{ old('nama', $jasa->nama) }}" required 
                    placeholder="Contoh: Print Skripsi Kilat / Jilid Hard Cover"
                    style="width: 100%; padding: 0.75rem 1rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none;">
            </div>

            <div class="form-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 1.25rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">
                        Tarif Jasa (Rp)
                    </label>
                    <input type="number" name="harga" aria-label="Harga" value="{{ old('harga', $jasa->harga) }}" required min="0" step="1000"
                        placeholder="Contoh: 15000"
                        style="width: 100%; padding: 0.75rem 1rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">
                        Estimasi Pengerjaan
                    </label>
                    <input type="text" name="durasi" aria-label="Durasi" value="{{ old('durasi', $jasa->durasi) }}" required 
                        placeholder="Contoh: 30 Menit / 1 - 2 Jam"
                        style="width: 100%; padding: 0.75rem 1rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">
                    Status Ketersediaan
                </label>
                <select name="status" aria-label="Status" required 
                    style="width: 100%; padding: 0.75rem 1rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none;">
                    <option value="aktif" {{ old('status', $jasa->status) === 'aktif' ? 'selected' : '' }}>Aktif (Siap Menerima Pesanan)</option>
                    <option value="nonaktif" {{ old('status', $jasa->status) === 'nonaktif' ? 'selected' : '' }}>Tutup Sementara</option>
                </select>
            </div>

            <div style="margin-bottom: 1.75rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">
                    Rincian & Cakupan Layanan
                </label>
                <textarea name="deskripsi" aria-label="Deskripsi" rows="4" 
                    placeholder="Jelaskan spesifikasi pengerjaan, ketentuan antar ke fakultas, atau catatan penting..."
                    style="width: 100%; padding: 0.75rem 1rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 10px; color: var(--text-main); font-size: 0.9rem; outline: none;">{{ old('deskripsi', $jasa->deskripsi) }}</textarea>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.85rem;">
                    <i class="fa-solid fa-floppy-disk"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Terbitkan Layanan Jasa' }}
                </button>
                <a href="{{ route('jasa.index') }}" class="btn btn-outline" style="padding: 0.85rem 1.5rem;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
