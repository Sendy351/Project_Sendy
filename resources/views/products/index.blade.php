@extends('layouts.app')

@section('title', 'Master Data Produk - CRUD Laravel')

@section('content')
<div class="container" style="margin-top: 24px;">

    <!-- Breadcrumb & Header Info Modul 6 -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
        <div>
            <h1 style="font-size: 1.6rem; font-weight: 800; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-boxes-stacked" style="color: var(--primary);"></i> Master Data: Produk
            </h1>
            <p style="color: var(--slate-500); font-size: 0.9rem;">
                Implementasi Resource Controller CRUD (Modul #6 ICT 025 & Proyek Database Backend)
            </p>
        </div>

        <a href="{{ route('products.create') }}" class="btn btn-success" style="font-weight: 700;">
            <i class="fa-solid fa-plus-circle"></i> + Add New Product
        </a>
    </div>

    <!-- Card Tabel Master Data Produk (Sesuai Screenshot Modul) -->
    <div class="crud-card">
        <div class="crud-card-header">
            <h2>
                <i class="fa-solid fa-table-list" style="color: var(--primary);"></i> Daftar Produk
            </h2>

            <!-- Form Pencarian Real-Time / Server-Side -->
            <form action="{{ route('products.index') }}" method="GET" style="display: flex; gap: 8px;">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari kode atau nama produk..." 
                       class="form-control" style="width: 260px; padding: 8px 14px; font-size: 0.85rem;">
                <button type="submit" class="btn btn-secondary btn-sm">
                    <i class="fa-solid fa-search"></i> Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm" title="Reset filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="crud-card-body">
            <div class="crud-table-wrapper">
                <table class="crud-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">S#</th>
                            <th style="width: 140px;">Code</th>
                            <th>Name</th>
                            <th style="width: 120px;">Quantity</th>
                            <th style="width: 160px;">Price</th>
                            <th style="width: 220px; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $index => $product)
                            <tr>
                                <td style="font-weight: 700; color: var(--slate-500);">
                                    {{ $products->firstItem() + $index }}
                                </td>
                                <td>
                                    <span class="badge-code">{{ $product->code }}</span>
                                </td>
                                <td>
                                    <strong style="color: var(--slate-800); font-size: 0.95rem;">{{ $product->name }}</strong>
                                    @if($product->description)
                                        <div style="font-size: 0.75rem; color: var(--slate-500); margin-top: 2px;">
                                            {{ Str::limit($product->description, 60) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-qty">
                                        <i class="fa-solid fa-cubes-stacked"></i> {{ $product->quantity }}
                                    </span>
                                </td>
                                <td>
                                    <span class="price-text">{{ $product->formatted_price }}</span>
                                </td>
                                <td style="text-align: center;">
                                    <div class="action-buttons" style="justify-content: center;">
                                        <!-- Tombol Show (Kuning) -->
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-warning btn-sm" title="Lihat Detail Produk">
                                            <i class="fa-solid fa-eye"></i> Show
                                        </a>

                                        <!-- Tombol Edit (Biru) -->
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm" title="Edit Data Produk">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>

                                        <!-- Tombol Delete (Merah) -->
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                                              onsubmit="return confirmSwal(this, { title: 'Hapus Produk {{ addslashes($product->name) }}?', text: 'Data produk ini akan dihapus secara permanen dari database.', icon: 'warning', confirmButtonText: 'Ya, Hapus Produk', confirmButtonColor: '#E11D48' });" 
                                              style="display: inline-block; margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Produk">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px 20px; color: var(--slate-500);">
                                    <i class="fa-solid fa-box-open" style="font-size: 2.5rem; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                                    Belum ada data produk. Klik tombol <strong>+ Add New Product</strong> untuk menambahkan produk pertama!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer Pagination & Records Info (Sesuai Screenshot Modul) -->
        <div class="crud-footer">
            <div>
                Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} records
            </div>
            <div>
                {{ $products->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
