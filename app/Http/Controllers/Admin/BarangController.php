<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function index(): View
    {
        $barangs = Barang::with('kategori')
            ->orderBy('nama_barang')
            ->paginate(10);

        return view('admin.barang.index', compact('barangs'));
    }

    public function create(): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.barang.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto-barang', 'public');
        }

        Barang::create($validated);

        return redirect()
            ->route('admin.barang.index')
            ->with('status', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.barang.edit', compact('barang', 'categories'));
    }

    public function update(Request $request, Barang $barang): RedirectResponse
    {
        $validated = $this->validated($request, $barang);

        if ($request->hasFile('foto')) {
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto-barang', 'public');
        }

        $barang->update($validated);

        return redirect()
            ->route('admin.barang.index')
            ->with('status', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang): RedirectResponse
    {
        try {
            $barang->delete();
        } catch (QueryException) {
            return redirect()
                ->route('admin.barang.index')
                ->with('error', 'Barang tidak bisa dihapus karena masih memiliki riwayat peminjaman.');
        }

        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        return redirect()
            ->route('admin.barang.index')
            ->with('status', 'Barang berhasil dihapus.');
    }

    private function validated(Request $request, ?Barang $barang = null): array
    {
        $uniqueKode = $barang
            ? 'unique:barangs,kode_barang,'.$barang->id_barang.',id_barang'
            : 'unique:barangs,kode_barang';

        return $request->validate([
            'id_kategori' => ['required', 'exists:categories,id_kategori'],
            'kode_barang' => ['required', 'string', 'max:50', $uniqueKode],
            'nama_barang' => ['required', 'string', 'max:100'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'stok' => ['required', 'integer', 'min:0'],
            'kondisi' => ['required', 'string', 'max:50'],
            'lokasi' => ['required', 'string', 'max:100'],
            'tanggal_pengadaan' => ['required', 'date'],
        ]);
    }
}
