<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:peminjam');
    }

    public function index(Request $request)
    {
        $query = Peminjaman::with(['detailPeminjamans.barang', 'pengembalians'])
            ->where('id_peminjam', Auth::guard('peminjam')->id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->latest('tanggal_pinjam')->get();

        return view('peminjam.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $barangs = Barang::where('stok', '>', 0)->orderBy('nama_barang')->get();

        return view('peminjam.peminjaman.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keperluan' => ['required', 'string'],
            'tanggal_pinjam' => ['required', 'date', 'after_or_equal:today'],
            'tanggal_rencana_kembali' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id_barang' => ['required', 'exists:barangs,id_barang'],
            'items.*.jumlah' => ['required', 'integer', 'min:1'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request) {
            $peminjaman = Peminjaman::create([
                'id_peminjam' => Auth::guard('peminjam')->id(),
                'id_admin' => null,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_rencana_kembali' => $request->tanggal_rencana_kembali,
                'keperluan' => $request->keperluan,
                'status' => 'diajukan',
            ]);

            foreach ($request->items as $item) {
                $peminjaman->detailPeminjamans()->create([
                    'id_barang' => $item['id_barang'],
                    'jumlah' => $item['jumlah'],
                ]);
            }
        });

        return redirect()
            ->route('peminjam.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim, menunggu verifikasi admin.');
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['detailPeminjamans.barang', 'admin', 'pengembalians'])
            ->where('id_peminjam', Auth::guard('peminjam')->id())
            ->findOrFail($id);

        return view('peminjam.peminjaman.show', compact('peminjaman'));
    }
}