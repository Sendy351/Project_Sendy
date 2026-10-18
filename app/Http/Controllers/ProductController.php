<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Tampilkan tabel daftar master data produk (Read).
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        return view('products.index', compact('products'));
    }

    /**
     * Tampilkan form untuk menambah produk baru (Create Form).
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Simpan data produk baru ke database (Store).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:50|unique:products,code',
            'name'        => 'required|string|max:255',
            'quantity'    => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ], [
            'code.required'     => 'Kode produk wajib diisi.',
            'code.unique'       => 'Kode produk sudah pernah digunakan.',
            'name.required'     => 'Nama produk wajib diisi.',
            'quantity.required' => 'Jumlah stok / quantity wajib diisi.',
            'price.required'    => 'Harga produk wajib diisi.',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail produk (Show).
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Tampilkan form edit produk (Edit Form).
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Perbarui data produk di database (Update).
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:50|unique:products,code,' . $product->id,
            'name'        => 'required|string|max:255',
            'quantity'    => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ], [
            'code.required'     => 'Kode produk wajib diisi.',
            'code.unique'       => 'Kode produk sudah digunakan produk lain.',
            'name.required'     => 'Nama produk wajib diisi.',
            'quantity.required' => 'Jumlah stok / quantity wajib diisi.',
            'price.required'    => 'Harga produk wajib diisi.',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Data produk berhasil diperbarui!');
    }

    /**
     * Hapus data produk dari database (Delete / Destroy).
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
