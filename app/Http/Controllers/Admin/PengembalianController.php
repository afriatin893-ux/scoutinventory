<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Notifications\StatusPeminjamanBerubah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengembalianController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('peminjam', 'detailPeminjamans.barang')
            ->where('status', 'dipinjam')
            ->orderBy('tanggal_rencana_kembali')
            ->paginate(10);

        return view('admin.pengembalian.index', compact('peminjamans'));
    }

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

            $jumlahKembali = $peminjaman->detailPeminjamans->sum('jumlah');

            Pengembalian::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'tanggal_pengembalian' => now()->toDateString(),
                'jumlah_kembali' => $jumlahKembali,
                'kondisi_barang' => $request->kondisi_barang,
                'foto_kondisi' => $fotoPath,
                'catatan' => $request->catatan,
            ]);

            foreach ($peminjaman->detailPeminjamans as $detail) {
                $detail->barang->increment('stok', $detail->jumlah);
            }

            $peminjaman->update(['status' => 'dikembalikan']);
        });

        $peminjaman->peminjam->notify(new StatusPeminjamanBerubah($peminjaman));

        return redirect()
            ->route('admin.peminjaman.index', ['status' => 'dikembalikan'])
            ->with('success', 'Pengembalian berhasil dicatat.');
    }
}
