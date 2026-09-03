<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function pending(): View
    {
        $peminjamans = Peminjaman::with('peminjam', 'detailPeminjamans.barang')
            ->where('status', 'Diajukan')
            ->orderBy('tanggal_pinjam')
            ->paginate(10);

        return view('admin.peminjaman.pending', compact('peminjamans'));
    }

    public function show(Peminjaman $peminjaman): View
    {
        $peminjaman->load('peminjam', 'admin', 'detailPeminjamans.barang', 'pengembalians');

        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function verifikasi(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        abort_unless($peminjaman->status === 'Diajukan', 400, 'Pengajuan ini sudah diproses sebelumnya.');

        $validated = $request->validate([
            'keputusan' => ['required', 'in:setuju,tolak'],
            'catatan_admin' => ['nullable', 'string', 'max:1000'],
        ]);

        $admin = Auth::guard('admin')->user();

        if ($validated['keputusan'] === 'tolak') {
            $peminjaman->update([
                'id_admin' => $admin->id_admin,
                'status' => 'Ditolak',
                'catatan_admin' => $validated['catatan_admin'],
            ]);

            return redirect()
                ->route('admin.peminjaman.pending')
                ->with('status', 'Pengajuan peminjaman ditolak.');
        }

        foreach ($peminjaman->detailPeminjamans as $detail) {
            if ($detail->jumlah > $detail->barang->stok) {
                return back()->withErrors([
                    'keputusan' => 'Stok "' . $detail->barang->nama_barang . '" tidak lagi mencukupi (' . $detail->barang->stok . ' tersisa).',
                ]);
            }
        }

        DB::transaction(function () use ($peminjaman, $admin, $validated) {
            foreach ($peminjaman->detailPeminjamans as $detail) {
                $detail->barang->decrement('stok', $detail->jumlah);
            }

            $peminjaman->update([
                'id_admin' => $admin->id_admin,
                'status' => 'dipinjam',
                'catatan_admin' => $validated['catatan_admin'],
            ]);
        });

        return redirect()
            ->route('admin.peminjaman.pending')
            ->with('status', 'Pengajuan disetujui, barang berstatus dipinjam dan stok telah dikurangi.');
    }
}
