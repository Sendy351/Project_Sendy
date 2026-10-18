<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman formulir login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('tasks.index');
        }

        // Ambil akun mahasiswa untuk kemudahan demo / testing
        $demoUsers = User::where('role', 'mahasiswa')->take(4)->get();

        return view('auth.login', compact('demoUsers'));
    }

    /**
     * Proses autentikasi login (mendukung login dengan Email atau NIM).
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required'    => 'Silakan masukkan Email atau NIM Anda.',
            'password.required' => 'Password tidak boleh kosong.',
        ]);

        $loginType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        $authAttempt = Auth::attempt([
            $loginType => $credentials['login'],
            'password' => $credentials['password'],
        ], $request->boolean('remember'));

        if ($authAttempt) {
            $request->session()->regenerate();
            return redirect()->intended(route('tasks.index'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()
            ->withInput($request->only('login', 'remember'))
            ->withErrors(['login' => 'Email/NIM atau password yang Anda masukkan salah.']);
    }

    /**
     * Login cepat 1-klik untuk akun demo mahasiswa (praktis untuk pengujian / dosen).
     */
    public function quickLogin(User $user, Request $request)
    {
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('tasks.index')
            ->with('success', 'Berhasil login sebagai: ' . $user->name . ' (' . $user->nim . ')');
    }

    /**
     * Alihkan akun secara instan dari navbar (simulasi multi-user testing).
     */
    public function switchUser(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);

        $user = User::findOrFail($request->user_id);
        Auth::login($user);

        return back()->with('success', "Akun aktif dialihkan ke: {$user->name} ({$user->nim})");
    }

    /**
     * Logout dari sistem.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
