<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\KategoriJasa;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoriList = KategoriJasa::withCount('jasa')->latest('dibuat_pada')->get();
        return view('kategori.index', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'ikon' => 'nullable|string|max:50',
        ]);

        KategoriJasa::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'ikon' => $request->ikon ?? 'wrench',
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori jasa baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriJasa::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'ikon' => 'nullable|string|max:50',
        ]);

        $kategori->update($request->only('nama', 'deskripsi', 'ikon'));

        return redirect()->route('kategori.index')->with('success', 'Kategori jasa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori = KategoriJasa::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori jasa berhasil dihapus.');
    }
}
