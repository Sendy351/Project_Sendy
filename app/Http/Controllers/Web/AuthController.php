<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\PenyediaJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('jasa.index');
        }

        $demoUsers = Pengguna::with('penyediaJasa')->get();
        return view('auth.login_proper', compact('demoUsers'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'kata_sandi' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->kata_sandi], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('jasa.index'))->with('success', 'Selamat datang kembali, ' . Auth::user()->nama . '!');
        }

        return back()->withInput($request->only('email'))->withErrors([
            'email' => 'Email atau kata sandi tidak cocok.',
        ]);
    }

    public function quickLogin($id, Request $request)
    {
        $pengguna = Pengguna::findOrFail($id);
        Auth::login($pengguna);
        $request->session()->regenerate();

        return redirect()->route('jasa.index')->with('success', 'Login berhasil sebagai ' . $pengguna->nama . ' (' . strtoupper($pengguna->peran) . ')');
    }

    public function showRegister()
    {
        return view('auth.register_proper');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'kata_sandi' => 'required|min:6|confirmed',
            'telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'peran' => 'required|in:pelanggan,penyedia',
        ]);

        $pengguna = Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'kata_sandi' => Hash::make($request->kata_sandi),
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'peran' => $request->peran,
        ]);

        if ($request->peran === 'penyedia') {
            PenyediaJasa::create([
                'pengguna_id' => $pengguna->id,
                'nama' => $pengguna->nama . ' Layanan Profesional',
                'telepon' => $pengguna->telepon,
                'alamat' => $pengguna->alamat,
                'deskripsi' => 'Penyedia layanan jasa profesional terpercaya.',
                'status' => 'aktif',
                'rating' => 5.00,
            ]);
        }

        Auth::login($pengguna);
        return redirect()->route('jasa.index')->with('success', 'Registrasi berhasil! Selamat datang di Jasa_Kita.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
