<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jasa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JasaController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Jasa::with(['kategori', 'penyedia']);

        if ($request->has('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->has('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }

        $jasa = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $jasa
        ]);
    }

    public function show($id): JsonResponse
    {
        $jasa = Jasa::with(['kategori', 'penyedia.pengguna'])->find($id);

        if (!$jasa) {
            return response()->json(['status' => 'error', 'message' => 'Layanan jasa tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $jasa
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategori_jasa,id',
            'penyedia_id' => 'required|exists:penyedia_jasa,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|string',
            'gambar' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $jasa = Jasa::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Layanan jasa berhasil dibuat',
            'data' => $jasa
        ], 201);
    }
}
