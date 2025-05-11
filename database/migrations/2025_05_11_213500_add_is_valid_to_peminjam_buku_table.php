<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsValidToPeminjamBukuTable extends Migration
{
    public function up()
    {
        Schema::table('peminjam_buku', function (Blueprint $table) {
            // Menambahkan kolom is_valid untuk menandai status validasi pengembalian
            $table->boolean('is_valid')->default(false); // Misalnya, default false untuk yang belum divalidasi
        });
    }

    public function down()
    {
        Schema::table('peminjam_buku', function (Blueprint $table) {
            // Menghapus kolom is_valid jika migration dibatalkan
            $table->dropColumn('is_valid');
        });
    }
}
