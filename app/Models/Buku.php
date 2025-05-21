<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Buku extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;

    protected $table = 'buku'; // opsional, hanya jika nama tabel berbeda
    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'sinopsis',
        'status',
        'gambar'
    ];
}

