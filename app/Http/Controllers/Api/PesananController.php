<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PermintaanJasa;
use App\Models\Pesanan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Pesanan::with(['pengguna', 'penyedia', 'permintaanJasa.jasa', 'pembayaran', 'ulasan']);

        if ($request->has('pengguna_id')) {
            $query->where('pengguna_id', $request->pengguna_id);
        }

        if ($request->has('penyedia_id')) {
            $query->where('penyedia_id', $request->penyedia_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json([
            'status' => 'success',
            'data' => $query->latest('dibuat_pada')->get()
        ]);
    }

    public function show($id): JsonResponse
    {
        $pesanan = Pesanan::with([
            'pengguna',
            'penyedia',
            'permintaanJasa.jasa.kategori',
            'pembayaran',
            'ulasan'
        ])->find($id);

        if (!$pesanan) {
            return response()->json(['status' => 'error', 'message' => 'Pesanan tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $pesanan
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'permintaan_id' => 'required|exists:permintaan_jasa,id|unique:pesanan,permintaan_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $permintaan = PermintaanJasa::findOrFail($request->permintaan_id);

        $pesanan = Pesanan::create([
            'permintaan_id' => $permintaan->id,
            'penyedia_id' => $permintaan->penyedia_id,
            'pengguna_id' => $permintaan->pengguna_id,
            'status' => 'diterima',
            'diterima_pada' => now(),
            'total_harga' => $permintaan->total_harga,
        ]);

        $permintaan->update(['status' => 'diproses']);

        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan berhasil dibuat dari permintaan jasa',
            'data' => $pesanan
        ], 201);
    }

    public function updateStatus(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:diterima,dimulai,selesai,dibatalkan',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $pesanan = Pesanan::findOrFail($id);

        $updateData = ['status' => $request->status];

        if ($request->status === 'dimulai' && !$pesanan->dimulai_pada) {
            $updateData['dimulai_pada'] = now();
        } elseif ($request->status === 'selesai' && !$pesanan->selesai_pada) {
            $updateData['selesai_pada'] = now();
        }

        $pesanan->update($updateData);

        return response()->json([
            'status' => 'success',
            'message' => 'Status pesanan berhasil diperbarui',
            'data' => $pesanan
        ]);
    }
}
