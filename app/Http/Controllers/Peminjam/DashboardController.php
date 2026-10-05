<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $peminjam = Auth::guard('peminjam')->user();

        $totalKategori = Kategori::count();
        $totalBarang = Barang::count();

        // Peminjaman terakhir milik peminjam ini (untuk kartu alur status).
        $terakhir = Peminjaman::with('detailPeminjamans.barang')
            ->where('id_peminjam', $peminjam->id_peminjam)
            ->latest()
            ->first();

        return view('peminjam.dashboard', compact('peminjam', 'totalKategori', 'totalBarang', 'terakhir'));
    }
}
