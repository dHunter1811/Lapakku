<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan Anda sudah membuat model User
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // Untuk validasi

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    /**
     * Memproses percobaan login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Redirect ke halaman setelah login berhasil (misalnya dashboard pengguna atau homepage)
            // Cek jika admin, redirect ke admin dashboard
            if (Auth::user()->role === 'admin') { // Asumsi ada kolom 'role' di tabel users
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan halaman registrasi.
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); // resources/views/auth/register.blade.php
    }

    /**
     * Memproses registrasi pengguna baru.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'], // Tambahkan 'name' jika diperlukan
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' akan mencocokkan dengan 'password_confirmation'
            'alamat' => ['nullable', 'string', 'max:255'], // Dari wireframe register
            'no_telepon' => ['nullable', 'string', 'max:20'], // Dari wireframe register
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name, // Jika ada input nama
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            // 'role' => 'user', // Set default role jika ada
        ]);

        Auth::login($user);

        // Redirect ke halaman setelah registrasi berhasil
        return redirect('/');
    }

    /**
     * Memproses logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); // Redirect ke homepage setelah logout
    }

    // Anda bisa menambahkan method untuk Lupa Password di sini
    // public function showLinkRequestForm() { ... }
    // public function sendResetLinkEmail(Request $request) { ... }
    // public function showResetForm($token) { ... }
    // public function reset(Request $request) { ... }
}