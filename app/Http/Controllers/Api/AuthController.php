<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Registrasi pengguna baru.
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna,email',
            'kata_sandi' => 'required|string|min:6',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'peran' => 'nullable|in:pengguna,penyedia,admin',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $pengguna = Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'kata_sandi' => Hash::make($request->kata_sandi),
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'peran' => $request->peran ?? 'pengguna',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengguna berhasil didaftarkan',
            'data' => $pengguna
        ], 201);
    }

    /**
     * Login pengguna.
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'kata_sandi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $pengguna = Pengguna::where('email', $request->email)->first();

        if (!$pengguna || !Hash::check($request->kata_sandi, $pengguna->kata_sandi)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau kata sandi tidak valid'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'pengguna' => $pengguna,
                'role' => $pengguna->peran
            ]
        ]);
    }

    /**
     * Ambil data pengguna saat ini.
     */
    public function profile($id): JsonResponse
    {
        $pengguna = Pengguna::with(['penyediaJasa'])->find($id);

        if (!$pengguna) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $pengguna
        ]);
    }
}
