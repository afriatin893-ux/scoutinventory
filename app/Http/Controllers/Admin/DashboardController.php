<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $admin = Auth::guard('admin')->user();

        $totalBarang = Barang::sum('stok');
        $pengajuanMenunggu = Peminjaman::where('status', 'Diajukan')->count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $terlambatKembali = Peminjaman::where('status', 'dipinjam')
            ->where('tanggal_rencana_kembali', '<', now())
            ->count();

        return view('admin.dashboard', compact(
            'admin',
            'totalBarang',
            'pengajuanMenunggu',
            'sedangDipinjam',
            'terlambatKembali'
        ));
    }
}
