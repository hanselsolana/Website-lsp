<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\File;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('welcome', compact('buku'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'nullable|string',
            'tahun_terbit' => 'nullable|integer',
            'sinopsis' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);
            $validated['gambar'] = 'uploads/' . $namaFile;
        }

        Buku::create($validated);

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

        $validated = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'nullable|string',
            'tahun_terbit' => 'nullable|integer',
            'sinopsis' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($buku->gambar && File::exists(public_path($buku->gambar))) {
                File::delete(public_path($buku->gambar));
            }

            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $namaFile);
            $validated['gambar'] = 'uploads/' . $namaFile;
        }

        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        // Hapus gambar dari server jika ada
        if ($buku->gambar && File::exists(public_path($buku->gambar))) {
            File::delete(public_path($buku->gambar));
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    public function hapusGambar($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->gambar && File::exists(public_path($buku->gambar))) {
            File::delete(public_path($buku->gambar));
        }

        $buku->gambar = null;
        $buku->save();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
    }
}
