<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Kategori::withCount('barangs')
            ->orderBy('nama_kategori')
            ->paginate(10);

        return view('admin.kategori.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', 'unique:categories,nama_kategori'],
        ]);

        Kategori::create($validated);

        return redirect()
            ->route('admin.kategori.index')
            ->with('status', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori): View
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => [
                'required', 'string', 'max:100',
                'unique:categories,nama_kategori,'.$kategori->id_kategori.',id_kategori',
            ],
        ]);

        $kategori->update($validated);

        return redirect()
            ->route('admin.kategori.index')
            ->with('status', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori): RedirectResponse
    {
        try {
            $kategori->delete();
        } catch (QueryException) {
            return redirect()
                ->route('admin.kategori.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih dipakai oleh barang.');
        }

        return redirect()
            ->route('admin.kategori.index')
            ->with('status', 'Kategori berhasil dihapus.');
    }
}
