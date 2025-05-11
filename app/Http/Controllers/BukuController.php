<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all(); // Ambil semua data buku dari database
        return view('welcome', compact('buku')); // Kirim data buku ke view 'welcome'
    }
    public function create()
{
    return view('buku.create');
}

public function store(Request $request)
{
    Buku::create($request->all());
    return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
}

public function edit($id)
{
    $buku = Buku::findOrFail($id);
    return view('buku.edit', compact('buku'));
}

public function update(Request $request, $id)
{
    $buku = Buku::findOrFail($id);
    $buku->update($request->all());
    return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
}

public function destroy($id)
{
    $buku = Buku::findOrFail($id);
    $buku->delete(); // soft delete
    return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
}

}
