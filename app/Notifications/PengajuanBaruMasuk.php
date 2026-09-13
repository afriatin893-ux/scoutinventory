<?php

namespace App\Notifications;

use App\Models\Peminjaman;
use Illuminate\Notifications\Notification;

class PengajuanBaruMasuk extends Notification
{
    public function __construct(public Peminjaman $peminjaman) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'peminjaman_id' => $this->peminjaman->id_peminjaman,
            'pesan' => 'Pengajuan peminjaman baru dari ' . $this->peminjaman->peminjam->nama,
        ];
    }
}