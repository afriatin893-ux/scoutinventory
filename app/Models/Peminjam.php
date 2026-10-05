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

    /**
     * Inisial nama untuk avatar saat belum ada foto.
     * "Atun Prasetyo" => "AP", "atun" => "A"
     */
    public function getInisialAttribute(): string
    {
        $kata = preg_split('/\s+/', trim($this->nama ?? ''), -1, PREG_SPLIT_NO_EMPTY);

        $inisial = '';
        foreach (array_slice($kata, 0, 2) as $k) {
            $inisial .= mb_strtoupper(mb_substr($k, 0, 1));
        }

        return $inisial !== '' ? $inisial : '?';
    }
}
