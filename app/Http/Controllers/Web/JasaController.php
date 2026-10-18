<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Jasa;
use App\Models\KategoriJasa;
use App\Models\PenyediaJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JasaController extends Controller
{
    public function index(Request $request)
    {
        $query = Jasa::with(['kategori', 'penyedia']);

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->q . '%');
        }

        $jasaList = $query->latest('dibuat_pada')->paginate(9);
        $kategoriList = KategoriJasa::withCount('jasa')->get();

        return view('jasa.index', compact('jasaList', 'kategoriList'));
    }

    public function show($id)
    {
        $jasa = Jasa::with(['kategori', 'penyedia.pengguna', 'penyedia.ulasan.pengguna'])->findOrFail($id);
        return view('jasa.show', compact('jasa'));
    }

    public function create()
    {
        $kategoriList = KategoriJasa::all();
        $penyediaList = PenyediaJasa::all();

        return view('jasa.form', [
            'jasa' => new Jasa(),
            'kategoriList' => $kategoriList,
            'penyediaList' => $penyediaList,
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_jasa,id',
            'nama'        => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'harga'       => 'required|numeric|min:0',
            'durasi'      => 'required|string|max:100',
            'gambar'      => 'nullable|string',
            'status'      => 'required|in:aktif,nonaktif',
        ]);

        // Jika user penyedia, gunakan id penyedianya
        $penyediaId = Auth::user()->penyediaJasa->id ?? PenyediaJasa::first()->id;
        $validated['penyedia_id'] = $penyediaId;

        Jasa::create($validated);

        return redirect()->route('jasa.index')->with('success', 'Layanan jasa baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jasa = Jasa::findOrFail($id);
        $kategoriList = KategoriJasa::all();
        $penyediaList = PenyediaJasa::all();

        return view('jasa.form', [
            'jasa' => $jasa,
            'kategoriList' => $kategoriList,
            'penyediaList' => $penyediaList,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $jasa = Jasa::findOrFail($id);

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_jasa,id',
            'nama'        => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'harga'       => 'required|numeric|min:0',
            'durasi'      => 'required|string|max:100',
            'gambar'      => 'nullable|string',
            'status'      => 'required|in:aktif,nonaktif',
        ]);

        $jasa->update($validated);

        return redirect()->route('jasa.show', $jasa->id)->with('success', 'Informasi jasa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jasa = Jasa::findOrFail($id);
        $jasa->delete();

        return redirect()->route('jasa.index')->with('success', 'Layanan jasa berhasil dihapus.');
    }
}
