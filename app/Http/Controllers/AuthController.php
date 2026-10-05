<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $dataKanggeLogin = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $konciKanggeRateLimitter = strtolower($request->username) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($konciKanggeRateLimitter, 5)) {
            $lilaDetik = RateLimiter::availableIn($konciKanggeRateLimitter);

            return back()->with(
                'error',
                "Terlalu banyak percobaan login. Silakan coba lagi dalam {$lilaDetik} detik."
            );
        }

        if (!Auth::attempt($dataKanggeLogin)) {
            RateLimiter::hit($konciKanggeRateLimitter, 60);

            return back()->with(
                'error',
                'Username atau password salah.'
            );
        }
        RateLimiter::clear($konciKanggeRateLimitter);

        $request->session()->regenerate();

     $user = Auth::user();

if ($user->role === 'admin') {
    return redirect()->route('admin.home');
}

if (!$user->anggota) {
    return redirect()->route('guest.profile');
}

if (
    empty($user->anggota->nama) ||
    empty($user->anggota->email) ||
    empty($user->anggota->tanggal_lahir) ||
    empty($user->anggota->jenis_kelamin) ||
    empty($user->anggota->alamat) ||
    empty($user->anggota->no_hp)
) {
    return redirect()->route('guest.profile');
}

return redirect()->route('guest.home');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
    'username' => 'required|string|max:50|unique:users,username',
    'password' => 'required|string|min:8|confirmed',
        ]);
$user = User::create([
    'username' => $validated['username'],
    'password' => bcrypt($validated['password']),
    'role' => 'guest',
]);


        return redirect()->route('login')->with(
            'success',
            'Akun Berhasil Dibuat'
        );
    }
}
