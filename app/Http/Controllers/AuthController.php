<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * ALUR REGISTER
     * 1. melakukan validasi input dari request (nama, email, password)
     * 2. membuat data user baru di database dan mengenkripsi password menggunakan bcrypt (Hash::make)
     * 3. melakukan login otomatis setelah pendaftaran berhasil menggunakan Auth::login
     * 4. mengarahkan pengguna langsung ke halaman dashboard utama
     */
    public function registerProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    /**
     * ALUR LOGIN
     * 1. melakukan validasi input email dan password
     * 2. mencocokkan kredensial di database dengan Auth::attempt
     * 3. jika cocok, session akan diregenerasi untuk mencegah session fixation attacks
     * 4. mengarahkan pengguna ke halaman tujuan (intended) atau default dashboard
     * 5. jika gagal, mengembalikan ke halaman login dengan pesan error
     */
    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau Password kamu salah, silahkan periksa kembali',
        ])->onlyInput('email');
    }

    /**
     * ALUR LOGIN ALTERNATIF
     * berfungsi sama dengan loginProcess untuk memproses autentikasi masuk pengguna
     */
    public function login_proses(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau Password kamu salah, silahkan periksa kembali',
        ])->onlyInput('email');
    }

    /**
     * LOGOUT
     * 1. mengeluarkan sesi otentikasi user menggunakan Auth::logout
     * 2. menghapus session aktif untuk membersihkan semua data sesi
     * 3. meregenerasi token CSRF baru untuk keamanan
     * 4. mengarahkan kembali pengguna ke halaman welcome page
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

