<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenyediaJasa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenyediaJasaController extends Controller
{
    public function index(): JsonResponse
    {
        $penyedia = PenyediaJasa::with(['pengguna', 'jasa'])->get();
        return response()->json([
            'status' => 'success',
            'data' => $penyedia
        ]);
    }

    public function show($id): JsonResponse
    {
        $penyedia = PenyediaJasa::with(['pengguna', 'jasa.kategori', 'ulasan.pengguna'])->find($id);

        if (!$penyedia) {
            return response()->json(['status' => 'error', 'message' => 'Penyedia jasa tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $penyedia
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'pengguna_id' => 'required|exists:pengguna,id|unique:penyedia_jasa,pengguna_id',
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $penyedia = PenyediaJasa::create([
            'pengguna_id' => $request->pengguna_id,
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
            'status' => 'aktif',
            'rating' => 0.00,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Penyedia jasa berhasil didaftarkan',
            'data' => $penyedia
        ], 201);
    }
}
