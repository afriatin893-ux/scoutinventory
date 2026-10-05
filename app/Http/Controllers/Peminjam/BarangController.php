<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function index(Request $request): View
    {
        $barangs = Barang::with('kategori')
            ->when($request->id_kategori, fn ($q) => $q->where('id_kategori', $request->id_kategori))
            ->when($request->q, fn ($q) => $q->where('nama_barang', 'like', '%' . $request->q . '%'))
            ->when(
                $request->urut === 'stok',
                fn ($q) => $q->orderByDesc('stok')->orderBy('nama_barang'),
                fn ($q) => $q->orderBy('nama_barang')
            )
            ->paginate(12)
            ->withQueryString();

        $categories = Kategori::withCount('barangs')->orderBy('nama_kategori')->get();
        $totalSemua = Barang::count();

        return view('peminjam.barang.index', compact('barangs', 'categories', 'totalSemua'));
    }
}
