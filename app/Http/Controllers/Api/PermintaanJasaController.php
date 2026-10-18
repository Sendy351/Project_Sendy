<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jasa;
use App\Models\PermintaanJasa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermintaanJasaController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = PermintaanJasa::with(['pengguna', 'jasa', 'penyedia', 'pesanan']);

        if ($request->has('pengguna_id')) {
            $query->where('pengguna_id', $request->pengguna_id);
        }

        if ($request->has('penyedia_id')) {
            $query->where('penyedia_id', $request->penyedia_id);
        }

        return response()->json([
            'status' => 'success',
            'data' => $query->latest('dibuat_pada')->get()
        ]);
    }

    public function show($id): JsonResponse
    {
        $permintaan = PermintaanJasa::with(['pengguna', 'jasa.kategori', 'penyedia', 'pesanan.pembayaran'])->find($id);

        if (!$permintaan) {
            return response()->json(['status' => 'error', 'message' => 'Permintaan jasa tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $permintaan
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'pengguna_id' => 'required|exists:pengguna,id',
            'jasa_id' => 'required|exists:jasa,id',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'required|string',
            'jadwal' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $jasa = Jasa::findOrFail($request->jasa_id);

        $permintaan = PermintaanJasa::create([
            'pengguna_id' => $request->pengguna_id,
            'jasa_id' => $jasa->id,
            'penyedia_id' => $jasa->penyedia_id,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'jadwal' => $request->jadwal,
            'status' => 'menunggu',
            'total_harga' => $jasa->harga,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Permintaan jasa berhasil diajukan',
            'data' => $permintaan
        ], 201);
    }
}
