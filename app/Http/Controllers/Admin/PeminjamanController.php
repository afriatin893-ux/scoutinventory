<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    /**
     * Daftar pengajuan yang masih menunggu verifikasi.
     */
    public function pending(): View
    {
        $peminjamans = Peminjaman::with('peminjam', 'detailPeminjamans.barang')
            ->where('status', 'Diajukan')
            ->orderBy('tanggal_pinjam')
            ->paginate(10);

        return view('admin.peminjaman.pending', compact('peminjamans'));
    }

    /**
     * Riwayat semua peminjaman (semua status).
     */
    public function index(Request $request): View
    {
        $peminjamans = Peminjaman::with('peminjam', 'detailPeminjamans.barang')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function show(Peminjaman $peminjaman): View
    {
        $peminjaman->load('peminjam', 'admin', 'detailPeminjamans.barang', 'pengembalians');

        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Setujui atau tolak pengajuan peminjaman.
     */
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

        // Validasi stok masih cukup untuk semua item sebelum disetujui.
        foreach ($peminjaman->detailPeminjamans as $detail) {
            if ($detail->jumlah > $detail->barang->stok) {
                return back()->withErrors([
                    'keputusan' => 'Stok "'.$detail->barang->nama_barang.'" tidak lagi mencukupi ('.$detail->barang->stok.' tersisa).',
                ]);
            }
        }

        DB::transaction(function () use ($peminjaman, $admin, $validated) {
            foreach ($peminjaman->detailPeminjamans as $detail) {
                $detail->barang->decrement('stok', $detail->jumlah);
            }

            $peminjaman->update([
                'id_admin' => $admin->id_admin,
                'status' => 'Disetujui',
                'catatan_admin' => $validated['catatan_admin'],
            ]);
        });

        return redirect()
            ->route('admin.peminjaman.pending')
            ->with('status', 'Pengajuan peminjaman disetujui, stok telah dikurangi.');
    }
}
