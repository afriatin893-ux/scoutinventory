<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Peminjam;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $admin = Auth::guard('admin')->user();

        $totalKategori = Kategori::count();
        $totalBarang = Barang::count();
        $totalStok = Barang::sum('stok');
        $totalPeminjam = Peminjam::count();

        return view('admin.dashboard', compact(
            'admin', 'totalKategori', 'totalBarang', 'totalStok', 'totalPeminjam'
        ));
    }
}
