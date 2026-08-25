<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs';
    protected $primaryKey = 'id_barang';
    protected $fillable = [
        'id_kategori',
        'kode_barang',
        'nama_barang',
        'stok',
        'kondisi',
        'lokasi',
        'tanggal_pengadaan',
    ];

     public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function detailPeminjamans()
    {
        return $this->hasMany(DetailPeminjaman::class,'id_barang','id_barang');
    }
}
