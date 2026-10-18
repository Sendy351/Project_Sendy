<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    public function show($id): JsonResponse
    {
        $pembayaran = Pembayaran::with(['pesanan.pengguna', 'pesanan.penyedia'])->find($id);

        if (!$pembayaran) {
            return response()->json(['status' => 'error', 'message' => 'Pembayaran tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $pembayaran
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'pesanan_id' => 'required|exists:pesanan,id|unique:pembayaran,pesanan_id',
            'metode' => 'required|string|in:transfer_bank,qris,tunai,kartu_kredit',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $pesanan = Pesanan::findOrFail($request->pesanan_id);

        $pembayaran = Pembayaran::create([
            'pesanan_id' => $pesanan->id,
            'metode' => $request->metode,
            'jumlah' => $pesanan->total_harga,
            'status' => 'berhasil',
            'tanggal_pembayaran' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran berhasil dikonfirmasi',
            'data' => $pembayaran
        ], 201);
    }
}
