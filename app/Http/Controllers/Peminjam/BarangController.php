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
            ->orderBy('nama_barang')
            ->paginate(10)
            ->withQueryString();

        $categories = Kategori::orderBy('nama_kategori')->get();

        return view('peminjam.barang.index', compact('barangs', 'categories'));
    }
}
