<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjam extends Model
{
    protected $table = 'peminjams';
    protected $primaryKey = 'id_peminjam';
    protected $fillable = [
        'nama',
        'asal_organisasi',
        'email',
        'password',
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_peminjam', 'id_peminjam');
    }
}
