<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $query = Peminjaman::with(['peminjam', 'detailPeminjamans.barang']);
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->latest('tanggal_pinjam')->get();
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function show(int $id)
    {
        $peminjaman = Peminjaman::with(['peminjam', 'admin', 'detailPeminjamans.barang', 'pengembalians'])->findOrFail($id);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function update(Request $request,int $id)
    {
        $peminjaman = Peminjaman::with('detailPeminjamans.barang')->findOrFail($id);
        $validator = Validator::make($request->all(), [
            'action' => ['required', 'in:verifikasi,serahkan'],
            'keputusan' => ['required_if:action,verifikasi', 'in:disetujui,ditolak'],
            'catatan_admin' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();}
        if ($request->action === 'verifikasi') {
            return $this->prosesVerifikasi($request, $peminjaman);}

        return $this->prosesSerahTerima($peminjaman);
    }

    private function prosesVerifikasi(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'diajukan') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }
        if ($request->keputusan === 'disetujui') {
            foreach ($peminjaman->detailPeminjamans as $detail) {
                if ($detail->jumlah > $detail->barang->stok) {
                    return back()->with('error', "Stok {$detail->barang->nama_barang} tidak mencukupi untuk disetujui.");
                }
            }
        }

        $peminjaman->update([
            'status' => $request->keputusan,
            'catatan_admin' => $request->catatan_admin,
            'id_admin' => Auth::guard('admin')->id(),
        ]);
        return back()->with('success', 'Pengajuan berhasil ' . $request->keputusan . '.');
    }

    private function prosesSerahTerima(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'disetujui') {
            return back()->with('error', 'Peminjaman harus berstatus disetujui sebelum diserahkan.');}
        DB::transaction(function () use ($peminjaman) {
            foreach ($peminjaman->detailPeminjamans as $detail) {
                if ($detail->jumlah > $detail->barang->stok) {
                    throw new \RuntimeException("Stok {$detail->barang->nama_barang} tidak mencukupi.");
                }

                $detail->barang->decrement('stok', $detail->jumlah);
            }

            $peminjaman->update(['status' => 'dipinjam']);
        });

        return back()->with('success', 'Barang berhasil ditandai sebagai dipinjam.');
    }
}
