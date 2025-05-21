<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGambarToBukuTable extends Migration
{
    public function up()
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('sinopsis');
        });
    }

    public function down()
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn('gambar');
        });
    }
}
