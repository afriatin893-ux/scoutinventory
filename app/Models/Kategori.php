<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id_kategori';
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id_kategori', 'id_kategori');
    }
}
