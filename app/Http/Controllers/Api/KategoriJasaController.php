<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriJasa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriJasaController extends Controller
{
    public function index(): JsonResponse
    {
        $kategori = KategoriJasa::withCount('jasa')->get();
        return response()->json([
            'status' => 'success',
            'data' => $kategori
        ]);
    }

    public function show($id): JsonResponse
    {
        $kategori = KategoriJasa::with(['jasa.penyedia'])->find($id);

        if (!$kategori) {
            return response()->json(['status' => 'error', 'message' => 'Kategori tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $kategori
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'ikon' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $kategori = KategoriJasa::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $kategori
        ], 201);
    }
}
