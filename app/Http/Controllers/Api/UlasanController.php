<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Ulasan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UlasanController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Ulasan::with(['pengguna', 'penyedia', 'pesanan.permintaanJasa.jasa']);

        if ($request->has('penyedia_id')) {
            $query->where('penyedia_id', $request->penyedia_id);
        }

        return response()->json([
            'status' => 'success',
            'data' => $query->latest('dibuat_pada')->get()
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'pesanan_id' => 'required|exists:pesanan,id',
            'pengguna_id' => 'required|exists:pengguna,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $pesanan = Pesanan::findOrFail($request->pesanan_id);

        $ulasan = Ulasan::create([
            'pesanan_id' => $pesanan->id,
            'pengguna_id' => $request->pengguna_id,
            'penyedia_id' => $pesanan->penyedia_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        // Update rata-rata rating pada penyedia jasa
        $avgRating = Ulasan::where('penyedia_id', $pesanan->penyedia_id)->avg('rating');
        $pesanan->penyedia()->update(['rating' => round($avgRating, 2)]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ulasan berhasil dikirimkan',
            'data' => $ulasan
        ], 201);
    }
}
