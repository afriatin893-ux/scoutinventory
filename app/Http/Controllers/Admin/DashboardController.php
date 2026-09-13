<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
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

        $grafikPeminjaman = Peminjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_pinjam', now()->year)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $labelBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $dataGrafik = [];
        foreach (range(1, 12) as $bulan) {
            $dataGrafik[] = $grafikPeminjaman[$bulan] ?? 0;
        }

        $barangTerpopuler = DetailPeminjaman::selectRaw('id_barang, SUM(jumlah) as total_dipinjam')
            ->groupBy('id_barang')
            ->orderByDesc('total_dipinjam')
            ->with('barang')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'admin', 'totalBarang', 'pengajuanMenunggu', 'sedangDipinjam',
            'terlambatKembali', 'labelBulan', 'dataGrafik', 'barangTerpopuler'
        ));
    }
}