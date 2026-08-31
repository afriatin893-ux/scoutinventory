<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\View\View;

class KategoriController extends Controller
{
    /**
     * Display a read-only listing of categories for peminjam.
     */
    public function index(): View
    {
        $kategoris = Kategori::withCount('barangs')
            ->orderBy('nama_kategori')
            ->paginate(10);

        return view('peminjam.kategori.index', compact('kategoris'));
    }
}
