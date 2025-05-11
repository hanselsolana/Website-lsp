<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidasiPengembalianTable extends Migration
{
    public function up()
    {
        Schema::create('validasi_pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjam_buku_id')->constrained()->onDelete('cascade');
            $table->boolean('is_valid')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('validasi_pengembalian');
    }
}
