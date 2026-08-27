<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Peminjam extends Authenticatable
{
    protected $table = 'peminjams';
    protected $primaryKey = 'id_peminjam';
    protected $fillable = [
        'nama',
        'asal_organisasi',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_peminjam', 'id_peminjam');
    }
}
