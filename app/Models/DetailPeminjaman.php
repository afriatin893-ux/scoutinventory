<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjamans';

    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_peminjaman',
        'id_barang',
        'jumlah',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(
            Peminjaman::class,
            'id_peminjaman',
            'id_peminjaman'
        );
    }

    public function barang()
    {
        return $this->belongsTo(
            Barang::class,
            'id_barang',
            'id_barang'
        );
    }
}
