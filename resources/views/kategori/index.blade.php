@extends('layouts.jasakita')

@section('title', 'Kategori Layanan Kampus - JasaKita')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <span style="background: var(--primary-light); color: var(--primary); font-size: 0.75rem; font-weight: 800; padding: 3px 8px; border-radius: 6px;">
            BIDANG & KATEGORI LAYANAN
        </span>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: var(--text-main); margin-top: 6px;">Kategori Layanan Kampus</h1>
        <p style="color: var(--text-muted); font-size: 0.85rem;">Klasifikasi keahlian dan jasa yang tersedia di lingkungan kampus.</p>
    </div>

    @auth
        @if(Auth::user()->isAdmin() || Auth::user()->isPenyedia())
            <button onclick="document.getElementById('modal-tambah-kategori').style.display='flex'" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus-circle"></i> Tambah Kategori
            </button>
        @endif
    @endauth
</div>

<!-- Category Cards Grid Clean -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
    @forelse($kategoriList as $item)
        <div class="card" style="background: #FFFFFF; border: 1px solid var(--border); border-radius: 14px; padding: 1.5rem; display: flex; flex-direction: column;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--primary-light); display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.35rem;">
                    <i class="fa-solid fa-{{ $item->ikon ?: 'tag' }}"></i>
                </div>
                <span style="background: var(--bg-subtle); color: var(--text-secondary); font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 999px;">
                    {{ $item->jasa_count }} Layanan
                </span>
            </div>

            <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.4rem;">
                {{ $item->nama }}
            </h3>
            
            <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5; margin-bottom: 1.25rem; flex: 1;">
                {{ $item->deskripsi ?: 'Kategori pendukung perkuliahan dan kebutuhan kampus.' }}
            </p>

            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid var(--border);">
                <a href="{{ route('jasa.index', ['kategori_id' => $item->id]) }}" style="color: var(--primary); font-size: 0.85rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; min-height: 44px;">
                    Buka Katalog &rarr;
                </a>

                @auth
                    @if(Auth::user()->isAdmin())
                        <div style="display: flex; gap: 6px;">
                            <button type="button" aria-label="Edit kategori" onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->nama) }}', '{{ addslashes($item->deskripsi) }}', '{{ $item->ikon }}')" class="btn btn-outline btn-sm">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirmSwal(this, { title: 'Hapus Kategori Jasa?', text: 'Kategori ini akan dihapus secara permanen.', icon: 'warning', confirmButtonText: 'Ya, Hapus', confirmButtonColor: '#E11D48' });" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-sm" aria-label="Hapus kategori" style="color: var(--rose); border-color: #FECDD3;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 14px;">
            <p style="color: var(--text-muted);">Belum ada kategori jasa yang dibuat.</p>
        </div>
    @endforelse
</div>

<!-- Modal Tambah Kategori -->
<div id="modal-tambah-kategori" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); z-index: 100; align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #FFFFFF; border: 1px solid var(--border); border-radius: 16px; width: 100%; max-width: 460px; padding: 2rem; box-shadow: var(--shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text-main);">Tambah Kategori Jasa</h3>
            <button onclick="document.getElementById('modal-tambah-kategori').style.display='none'" class="modal-close" aria-label="Tutup">&times;</button>
        </div>

        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Nama Kategori</label>
                <input type="text" name="nama" aria-label="Nama" required placeholder="Contoh: Print & Jilid Skripsi"
                    style="width: 100%; padding: 0.75rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 8px; color: var(--text-main); font-size: 0.9rem; outline: none;">
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Ikon FontAwesome (Class)</label>
                <input type="text" name="ikon" aria-label="Ikon" value="print" placeholder="print / motorcycle / laptop-code / chart-pie"
                    style="width: 100%; padding: 0.75rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 8px; color: var(--text-main); font-size: 0.9rem; outline: none;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Deskripsi Singkat</label>
                <textarea name="deskripsi" aria-label="Deskripsi" rows="3" placeholder="Uraikan cakupan jenis jasa kampus ini..."
                    style="width: 100%; padding: 0.75rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 8px; color: var(--text-main); font-size: 0.9rem; outline: none;"></textarea>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.75rem;">Simpan Kategori</button>
                <button type="button" onclick="document.getElementById('modal-tambah-kategori').style.display='none'" class="btn btn-outline" style="padding: 0.75rem;">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div id="modal-edit-kategori" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); z-index: 100; align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: #FFFFFF; border: 1px solid var(--border); border-radius: 16px; width: 100%; max-width: 460px; padding: 2rem; box-shadow: var(--shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text-main);">Edit Kategori Jasa</h3>
            <button onclick="document.getElementById('modal-edit-kategori').style.display='none'" class="modal-close" aria-label="Tutup">&times;</button>
        </div>

        <form id="form-edit-kategori" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Nama Kategori</label>
                <input type="text" id="edit-nama" name="nama" required 
                    style="width: 100%; padding: 0.75rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 8px; color: var(--text-main); font-size: 0.9rem; outline: none;">
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Ikon FontAwesome</label>
                <input type="text" id="edit-ikon" name="ikon" 
                    style="width: 100%; padding: 0.75rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 8px; color: var(--text-main); font-size: 0.9rem; outline: none;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Deskripsi</label>
                <textarea id="edit-deskripsi" name="deskripsi" rows="3" 
                    style="width: 100%; padding: 0.75rem; background: #FFFFFF; border: 1px solid var(--border); border-radius: 8px; color: var(--text-main); font-size: 0.9rem; outline: none;"></textarea>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.75rem;">Simpan Perubahan</button>
                <button type="button" onclick="document.getElementById('modal-edit-kategori').style.display='none'" class="btn btn-outline" style="padding: 0.75rem;">Batal</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openEditModal(id, nama, deskripsi, ikon) {
        document.getElementById('form-edit-kategori').action = '/kategori/' + id;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-deskripsi').value = deskripsi;
        document.getElementById('edit-ikon').value = ikon;
        document.getElementById('modal-edit-kategori').style.display = 'flex';
    }
</script>
@endsection
