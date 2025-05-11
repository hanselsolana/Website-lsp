<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login'); // pastikan ada view auth.login
    }

    // Metode untuk menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses autentikasi login
    public function authenticate(Request $request)
    {
        // Validasi User ID dan Password
        $request->validate([
            'user_id' => 'required',
            'password' => 'required',
        ]);

        // Periksa apakah user_id dan password sesuai dengan data yang diberikan
        if ($request->user_id == '12345' && $request->password == 'UC2025') {
            // Redirect ke halaman admin (Daftar Buku)
            return redirect()->route('buku.index');
        } else {
            // Jika login gagal, kembalikan pesan error
            return redirect()->back()->with('error', 'User ID atau Password salah. Silahkan coba lagi.');
        }
    }
}
