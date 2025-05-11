<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('buku', function (Blueprint $table) {
            // Pastikan kolom status_peminjaman ada setelah sinopsis
            // Menggunakan after() hanya jika kolom sinopsis sudah ada
            $table->string('status_peminjaman')->default('tersedia')->after('sinopsis');
        });
    }

    public function down(): void {
        Schema::table('buku', function (Blueprint $table) {
            // Menghapus kolom status_peminjaman
            $table->dropColumn('status_peminjaman');
        });
    }
};
