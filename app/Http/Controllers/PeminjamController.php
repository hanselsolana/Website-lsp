<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamBuku;
use App\Models\Buku;
use Carbon\Carbon;

class PeminjamController extends Controller
{
    // Tampilkan form peminjaman untuk mahasiswa
    public function form()
    {
        $buku = Buku::where('status_peminjaman', 'tersedia')->get();
        return view('mahasiswa.form', compact('buku'));
    }

    // Proses submit peminjaman
    public function submit(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
            'buku_id' => 'required|exists:buku,id',
        ]);

        $buku = Buku::findOrFail($request->buku_id);
        if ($buku->status_peminjaman === 'dipinjam') {
            return back()->withErrors(['buku_id' => 'Buku tidak tersedia.'])->withInput();
        }

        $tanggal_pengembalian = Carbon::parse($request->tanggal_pinjam)->addDays(7);

        PeminjamBuku::create([
            'nama' => $request->nama,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $tanggal_pengembalian,
            'buku_id' => $buku->id,
        ]);

        $buku->status_peminjaman = 'dipinjam';
        $buku->save();

        return redirect('/')->with('success', 'Peminjaman berhasil dicatat.');
    }

    // Tampilkan form pengembalian buku
    public function formPengembalian()
    {
        return view('mahasiswa.pengembalian');
    }

    // Proses pengembalian buku
    public function submitPengembalian(Request $request)
    {
        $request->validate(['nama' => 'required|string']);

        $peminjaman = PeminjamBuku::where('nama', $request->nama)
            ->whereNull('dikembalikan_pada')
            ->latest()->first();

        if (!$peminjaman) {
            return back()->withErrors(['nama' => 'Tidak ada buku yang sedang dipinjam oleh nama ini.']);
        }

        $peminjaman->dikembalikan_pada = now();
        $peminjaman->save();

        return redirect()->back()->with('success', 'Permintaan pengembalian berhasil dikirim. Menunggu validasi admin.');
    }

    // Admin: tampilkan semua peminjaman dan pengembalian
    public function adminDashboard()
    {
        $daftarBuku = Buku::all();
        $pengembalian = PeminjamBuku::whereNotNull('dikembalikan_pada')->get();

        return view('admin.dashboard', compact('daftarBuku', 'pengembalian'));
    }

    // Admin: checklist pengembalian resmi
    public function checklistPengembalian($id)
    {
        $peminjaman = PeminjamBuku::findOrFail($id);
        $peminjaman->status_pengembalian = 'selesai';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Pengembalian telah ditandai selesai.');
    }

    // Proses Get Data
    public function getDataPengembalian(Request $request)
    {
        $nama = $request->query('nama');

        $peminjaman = PeminjamBuku::with('buku')
            ->where('nama', $nama)
            ->whereNull('dikembalikan_pada')
            ->latest()
            ->first();

        if (!$peminjaman) {
            return response()->json(['judul' => '', 'tanggal_kembali' => '']);
        }

        return response()->json([
            'judul' => $peminjaman->buku->judul ?? '',
            'tanggal_kembali' => $peminjaman->tanggal_kembali ?? ''
        ]);
    }

    // Menampilkan daftar peminjam yang belum divalidasi
    public function daftarPeminjam()
    {
        $pengembalians = PeminjamBuku::whereNotNull('dikembalikan_pada')
            ->whereNull('status_pengembalian')
            ->with('buku')
            ->get();

        return view('admin.daftar_peminjam', compact('pengembalians'));
    }

    // Memproses checklist validasi
    public function validasiPengembalian(Request $request)
    {
        $ids = $request->input('validasi_ids', []);

        foreach ($ids as $id) {
            $peminjaman = PeminjamBuku::find($id);
            if ($peminjaman) {
                $peminjaman->status_pengembalian = 'selesai';
                $peminjaman->save();

                // Update status buku
                $peminjaman->buku->status_peminjaman = 'tersedia';
                $peminjaman->buku->save();
            }
        }

        return redirect()->back()->with('success', 'Pengembalian telah divalidasi dan buku tersedia kembali.');
    }
}
