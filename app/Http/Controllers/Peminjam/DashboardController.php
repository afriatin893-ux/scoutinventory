<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $peminjam = Auth::guard('peminjam')->user();

        $totalKategori = Kategori::count();
        $totalBarang = Barang::count();

        return view('peminjam.dashboard', compact('peminjam', 'totalKategori', 'totalBarang'));
    }
}
