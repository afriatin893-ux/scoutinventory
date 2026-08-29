<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $categories = Kategori::orderBy('nama_kategori')->get();
        return view('admin.kategori.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:categories,nama_kategori'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        Kategori::create($validator->validated());
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show( int $id)
    {
        $kategori = Kategori::with('barangs')->findOrFail($id);
        return view('admin.kategori.show', compact('kategori'));
    }

    public function edit(int $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request,int $id)
    {
        $kategori = Kategori::findOrFail($id);
        $validator = Validator::make($request->all(), ['nama_kategori' => ['required', 'string', 'max:100', 'unique:categories,nama_kategori,' . $kategori->id_kategori . ',id_kategori'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();}
        $kategori->update($validator->validated());
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $kategori = Kategori::findOrFail($id);
        if ($kategori->barangs()->exists()) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih dipakai oleh barang.');}

        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
