<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showLoginForm()
{
    return view('admin.login');
}

public function checkLogin(Request $request)
{
    if ($request->user_id == '12345' && $request->password == 'UC2025') {
        return redirect()->route('buku.index');
    } else {
        return redirect()->route('admin.login')->with('error', 'User ID atau Password salah. Silahkan coba lagi.');
    }
}

}
