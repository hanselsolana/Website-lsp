<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamBuku extends Model
{
    protected $table = 'peminjam_buku';

    protected $fillable = [
        'nama', 'tanggal_pinjam', 'tanggal_kembali', 'buku_id'
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}