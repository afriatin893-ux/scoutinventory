<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        $barangs = Barang::with('kategori')->orderBy('nama_barang')->get();
        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        $categories = Kategori::orderBy('nama_kategori')->get();
        return view('admin.barang.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kategori' => ['required', 'exists:categories,id_kategori'],
            'kode_barang' => ['required', 'string', 'max:50', 'unique:barangs,kode_barang'],
            'nama_barang' => ['required', 'string', 'max:100'],
            'stok' => ['required', 'integer', 'min:0'],
            'kondisi' => ['required', 'string', 'max:50'],
            'lokasi' => ['required', 'string', 'max:100'],
            'tanggal_pengadaan' => ['required', 'date'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Barang::create($validator->validated());
        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(int $id)
    {
        $barang = Barang::with('kategori', 'detailPeminjamans.peminjaman')->findOrFail($id);
        return view('admin.barang.show', compact('barang'));
    }

    public function edit(int $id)
    {
        $barang = Barang::findOrFail($id);
        $categories = Kategori::orderBy('nama_kategori')->get();
        return view('admin.barang.edit', compact('barang', 'categories'));
    }

    // PUT/PATCH /admin/barang/{id}
    public function update(Request $request,int $id)
    {
        $barang = Barang::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_kategori' => ['required', 'exists:categories,id_kategori'],
            'kode_barang' => ['required', 'string', 'max:50', 'unique:barangs,kode_barang,' . $barang->id_barang . ',id_barang'],
            'nama_barang' => ['required', 'string', 'max:100'],
            'stok' => ['required', 'integer', 'min:0'],
            'kondisi' => ['required', 'string', 'max:50'],
            'lokasi' => ['required', 'string', 'max:100'],
            'tanggal_pengadaan' => ['required', 'date'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $barang->update($validator->validated());
        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil diperbarui.');
    }
    public function destroy(int $id)
    {
        $barang = Barang::findOrFail($id);
        if ($barang->detailPeminjamans()->exists()) {
            return back()->with('error', 'Barang tidak bisa dihapus karena memiliki riwayat peminjaman.');
        }

        $barang->delete();
        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
