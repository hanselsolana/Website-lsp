<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('peminjam_buku', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->date('tanggal_pinjam');
        $table->date('tanggal_kembali');
        $table->unsignedBigInteger('buku_id');
        $table->timestamps();

        $table->foreign('buku_id')->references('id')->on('buku')->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjam_buku');
    }
};
