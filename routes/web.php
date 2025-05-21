<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeminjamController;
use Illuminate\Http\Request;
use App\Models\PeminjamBuku;
use App\Http\Controllers\AdminController;

// Halaman utama (pilihan Admin atau Mahasiswa)
Route::get('/', function () {
    return view('home'); // Halaman utama: pilih Admin atau Mahasiswa
})->name('home');

// Route untuk login admin
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'authenticate'])->name('admin.login.post');


// Route untuk halaman Daftar Buku (admin)
Route::get('/admin/dashboard', [BukuController::class, 'index'])->middleware('admin')->name('admin.dashboard');

// CRUD Buku untuk admin
Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');

// Route untuk form peminjaman buku (mahasiswa)
Route::get('/mahasiswa/form', [PeminjamController::class, 'form'])->name('mahasiswa.form');
Route::post('/mahasiswa/pinjam', [PeminjamController::class, 'store'])->name('mahasiswa.pinjam');

// Logout Route (optional, jika ingin implementasi logout)
Route::get('/logout', function () {
    session()->flush();
    return redirect('/');
})->name('logout');

// Route untuk halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');

// Route untuk menangani proses login
Route::post('/login', [AuthController::class, 'authenticate'])->name('admin.authenticate');

// Route untuk mengarahkan ke halaman Daftar Buku
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

// Route Mahasiswa Submit
Route::post('/mahasiswa/submit', [PeminjamController::class, 'submit'])->name('mahasiswa.submit');

Route::get('/mahasiswa', [PeminjamController::class, 'form'])->name('mahasiswa.form');

// Form pengembalian buku
Route::get('/mahasiswa/pengembalian', [PeminjamController::class, 'formPengembalian'])->name('mahasiswa.pengembalian');
Route::post('/mahasiswa/pengembalian', [PeminjamController::class, 'submitPengembalian'])->name('mahasiswa.pengembalian.submit');

// Admin: Tampilkan data pengembalian
Route::get('/admin/dashboard', [PeminjamController::class, 'adminDashboard'])->middleware('admin')->name('admin.dashboard');

// Admin: checklist pengembalian
Route::post('/admin/pengembalian/{id}/checklist', [PeminjamController::class, 'checklistPengembalian'])->name('admin.pengembalian.checklist');

Route::get('/mahasiswa', function () {
    return view('mahasiswa.menu');
})->name('mahasiswa.menu');

// Form pengembalian buku
Route::get('/mahasiswa/pengembalian', [PeminjamController::class, 'showPengembalianForm'])->name('mahasiswa.return.form');
Route::post('/mahasiswa/pengembalian', [PeminjamController::class, 'submitPengembalian'])->name('mahasiswa.return.submit');

Route::get('/api/cek-peminjaman', function (Request $request) {
    $peminjaman = \App\Models\PeminjamBuku::with('buku')
        ->where('nama', $request->nama)
        ->whereNull('dikembalikan_pada')
        ->latest()
        ->first();

    if (!$peminjaman) {
        return response()->json(null);
    }

    return response()->json([
        'buku' => $peminjaman->buku->judul,
        'tanggal_kembali' => \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('Y-m-d'),
    ]);
});

Route::get('/api/pengembalian/data', function (Request $request) {
    $peminjaman = \App\Models\PeminjamBuku::with('buku')
        ->where('nama', $request->nama)
        ->whereNull('dikembalikan_pada')
        ->latest()
        ->first();

    if (!$peminjaman) {
        return response()->json([]);
    }

    return response()->json([
        'judul' => $peminjaman->buku->judul,
        'tanggal_kembali' => $peminjaman->tanggal_kembali,
    ]);
});


Route::get('/mahasiswa/pengembalian', [PeminjamController::class, 'formPengembalian'])->name('mahasiswa.form.pengembalian');
Route::post('/mahasiswa/pengembalian', [PeminjamController::class, 'submitPengembalian'])->name('mahasiswa.submit.pengembalian');
Route::post('/mahasiswa/pengembalian', [PeminjamController::class, 'submitPengembalian'])->name('mahasiswa.pengembalian.submit');

Route::get('/api/pengembalian/data', function (Illuminate\Http\Request $request) {
    $nama = $request->query('nama');
    $peminjaman = \App\Models\PeminjamBuku::where('nama', $nama)
        ->whereNull('dikembalikan_pada')
        ->latest()->first();

    if (!$peminjaman) {
        return response()->json([]);
    }

    return response()->json([
        'judul' => $peminjaman->buku->judul ?? '',
        'tanggal_kembali' => $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('Y-m-d') : '',
    ]);
});

Route::get('/api/pengembalian/data', function (Request $request) {
    $nama = $request->query('nama');

    $peminjaman = PeminjamBuku::where('nama', $nama)
        ->whereNull('dikembalikan_pada')
        ->latest()
        ->with('buku') // penting untuk eager load
        ->first();

    if (!$peminjaman) {
        return response()->json([
            'judul' => '',
            'tanggal_kembali' => '',
        ]);
    }

    return response()->json([
        'judul' => $peminjaman->buku->judul ?? '',
        'tanggal_kembali' => optional($peminjaman->tanggal_kembali)->format('Y-m-d'),
    ]);
});

Route::get('/api/pengembalian/data', [PeminjamController::class, 'getDataPengembalian']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/daftar-peminjam', [PeminjamController::class, 'daftarPeminjam'])->name('admin.daftar.peminjam');
    Route::post('/admin/validasi-pengembalian', [PeminjamController::class, 'validasiPengembalian'])->name('admin.validasi.pengembalian');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Halaman dashboard admin
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Daftar buku (jika sudah ada, abaikan)
    Route::get('/buku', [AdminController::class, 'bukuIndex'])->name('admin.buku.index');

    // Daftar peminjam menunggu validasi
    Route::get('/pengembalian', [AdminController::class, 'pengembalianIndex'])->name('admin.pengembalian.index');
    Route::post('/pengembalian/validasi', [AdminController::class, 'validasiPengembalian'])->name('admin.validasi.pengembalian');
});

// Rute Admin dengan middleware 'admin'
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/buku', [AdminController::class, 'daftarBuku'])->name('buku');
    Route::get('/pengembalian', [AdminController::class, 'daftarPeminjam'])->name('pengembalian');
    Route::post('/validasi-pengembalian', [AdminController::class, 'validasiPengembalian'])->name('validasi.pengembalian');
});

// Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [PeminjamController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/daftar-peminjam', [PeminjamController::class, 'daftarPeminjam'])->name('admin.daftar.peminjam');
    Route::post('/admin/validasi-pengembalian', [PeminjamController::class, 'validasiPengembalian'])->name('admin.validasi.pengembalian');
    
    // Jika Anda punya controller lain untuk buku
    Route::get('/admin/buku', [BukuController::class, 'index'])->name('admin.buku.index');
});

// Halaman utama (akses mahasiswa tanpa login)
Route::post('/pinjam', [PeminjamController::class, 'submit'])->name('mahasiswa.submit');
Route::get('/pengembalian', [PeminjamController::class, 'formPengembalian'])->name('mahasiswa.pengembalian.form');
Route::post('/pengembalian', [PeminjamController::class, 'submitPengembalian'])->name('mahasiswa.pengembalian.submit');
Route::get('/get-data-pengembalian', [PeminjamController::class, 'getDataPengembalian'])->name('pengembalian.getdata');

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Grup route admin dengan middleware auth dan admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [PeminjamController::class, 'adminDashboard'])->name('admin.dashboard');

    Route::get('/admin/buku', [BukuController::class, 'index'])->name('admin.buku.index');
    Route::get('/admin/buku/create', [BukuController::class, 'create'])->name('admin.buku.create');
    Route::post('/admin/buku/store', [BukuController::class, 'store'])->name('admin.buku.store');
    Route::get('/admin/buku/{id}/edit', [BukuController::class, 'edit'])->name('admin.buku.edit');
    Route::put('/admin/buku/{id}', [BukuController::class, 'update'])->name('admin.buku.update');
    Route::delete('/admin/buku/{id}', [BukuController::class, 'destroy'])->name('admin.buku.destroy');

    // Daftar peminjam dan validasi
    Route::get('/admin/daftar-peminjam', [PeminjamController::class, 'daftarPeminjam'])->name('admin.daftar.peminjam');
    Route::post('/admin/validasi-pengembalian', [PeminjamController::class, 'validasiPengembalian'])->name('admin.validasi.pengembalian');

// Route untuk menghapus gambar
Route::get('/buku/{id}/hapus-gambar', [BukuController::class, 'hapusGambar'])->name('buku.hapusGambar');

});
