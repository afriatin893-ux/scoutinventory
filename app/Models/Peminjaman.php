<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = [
        'id_peminjam',
        'id_admin',
        'tanggal_pinjam',
        'tanggal_rencana_kembali',
        'keperluan',
        'status',
        'catatan_admin',
    ];

    public function peminjam()
    {
        return $this->belongsTo(
            Peminjam::class,'id_peminjam','id_peminjam');
    }

    public function admin()
    {
        return $this->belongsTo(
            Admin::class,'id_admin','id_admin');
    }

    public function detailPeminjamans()
    {
        return $this->hasMany(
            DetailPeminjaman::class,'id_peminjaman','id_peminjaman');
    }

    public function pengembalians()
    {
        return $this->hasMany(
            Pengembalian::class,'id_peminjaman','id_peminjaman');
    }
}
