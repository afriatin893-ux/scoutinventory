<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalians';
    protected $primaryKey = 'id_pengembalian';
    protected $fillable = [
        'id_peminjaman',
        'tanggal_pengembalian',
        'jumlah_kembali',
        'kondisi_barang',
        'foto_kondisi',
        'catatan',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(
            Peminjaman::class,'id_peminjaman','id_peminjaman');
    }
}
