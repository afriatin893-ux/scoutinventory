<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengembalianController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function create(int $idPeminjaman)
    {
        $peminjaman = Peminjaman::with('detailPeminjamans.barang')->findOrFail($idPeminjaman);
        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('error', 'Peminjaman ini belum berstatus dipinjam.');
        }
        return view('admin.pengembalian.create', compact('peminjaman'));
    }

    public function store(Request $request, int $idPeminjaman)
    {
        $peminjaman = Peminjaman::with('detailPeminjamans.barang')->findOrFail($idPeminjaman);
        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('error', 'Peminjaman ini belum berstatus dipinjam.');
        }
        $validator = Validator::make($request->all(), [
            'tanggal_pengembalian' => ['required', 'date'],
            'jumlah_kembali' => ['required', 'integer', 'min:1'],
            'kondisi_barang' => ['required', 'string', 'max:50'],
            'foto_kondisi' => ['nullable', 'image', 'max:2048'],
            'catatan' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request, $peminjaman) {
            $fotoPath = null;
            if ($request->hasFile('foto_kondisi')) {
                $fotoPath = $request->file('foto_kondisi')->store('kondisi_barang', 'public');
            }

            Pengembalian::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'tanggal_pengembalian' => $request->tanggal_pengembalian,
                'jumlah_kembali' => $request->jumlah_kembali,
                'kondisi_barang' => $request->kondisi_barang,
                'foto_kondisi' => $fotoPath,
                'catatan' => $request->catatan,
            ]);

            foreach ($peminjaman->detailPeminjamans as $detail) {
                $detail->barang->increment('stok', $detail->jumlah);
            }

            $peminjaman->update(['status' => 'dikembalikan']);
        });

        return redirect()
            ->route('admin.peminjaman.show', $peminjaman->id_peminjaman)
            ->with('success', 'Pengembalian berhasil dicatat, stok telah diperbarui.');
    }
}
