<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamBuku;
use App\Models\Buku;

class PeminjamController extends Controller
{
    public function form()
    {
        $buku = Buku::all();
        return view('mahasiswa.form', compact('buku'));
    }

    public function submit(Request $request)
{
    $request->validate([
    'nama' => 'required|string|max:255',
    'tanggal_pinjam' => 'required|date|after_or_equal:today',
    'buku_id' => 'required|exists:bukus,id',
    'tanggal_pinjam.after_or_equal' => 'Tanggal pinjam tidak boleh di masa lalu.',
]);

        // Hitung tanggal kembali = tanggal pinjam + 7 hari
        $tanggal_kembali = date('Y-m-d', strtotime($request->tanggal_pinjam . ' +7 days'));

        PeminjamBuku::create([
            'nama' => $request->nama,
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => $tanggal_kembali,
            'buku_id' => $request->buku_id,
        ]);

        return redirect()->route('mahasiswa.form')->with('success', 'Peminjaman berhasil disimpan.');
    }
}
