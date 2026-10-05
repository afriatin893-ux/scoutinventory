<?php

namespace App\Models;

use Carbon\Carbon;
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

    /**
     * Membandingkan tanggal pengembalian dengan tanggal rencana kembali.
     * Hasil: ['label' => teks, 'badge' => kelas CSS badge]
     */
    public function getKeteranganWaktuAttribute(): array
    {
        $rencana = Carbon::parse($this->peminjaman->tanggal_rencana_kembali)->startOfDay();
        $aktual  = Carbon::parse($this->tanggal_pengembalian)->startOfDay();
        $selisih = (int) $rencana->diffInDays($aktual, true);

        if ($aktual->lt($rencana)) {
            return ['label' => 'Lebih awal ' . $selisih . ' hari', 'badge' => 'badge-info'];
        }
        if ($aktual->gt($rencana)) {
            return ['label' => 'Terlambat ' . $selisih . ' hari', 'badge' => 'badge-bad'];
        }
        return ['label' => 'Tepat waktu', 'badge' => 'badge-good'];
    }

    public function peminjaman()
    {
        return $this->belongsTo(
            Peminjaman::class,'id_peminjaman','id_peminjaman');
    }
}
