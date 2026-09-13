<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Peminjam extends Authenticatable
{
    use Notifiable;
    protected $table = 'peminjams';
    protected $primaryKey = 'id_peminjam';
    protected $fillable = [
        'nama',
        'asal_organisasi',
        'email',
        'password',
        'no_telepon',
        'foto',
    ];

    protected $hidden = [
        'password',
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_peminjam', 'id_peminjam');
    }
}
