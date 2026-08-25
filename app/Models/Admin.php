<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id_admin';
    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_admin', 'id_admin');
    }
}
