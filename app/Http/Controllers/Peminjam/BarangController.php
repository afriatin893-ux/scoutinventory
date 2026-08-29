<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Barang;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:peminjam');
    }

    public function index()
    {
        $barangs = Barang::with('kategori')->orderBy('nama_barang')->get();
        return view('peminjam.barang.index', compact('barangs'));
    }

    public function show(int $id)
    {
        $barang = Barang::with('kategori')->findOrFail($id);
        return view('peminjam.barang.show', compact('barang'));
    }
}