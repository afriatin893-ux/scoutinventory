<?php

namespace App\Http\Controllers\Peminjam;

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
     * Riwayat & status peminjaman milik peminjam yang sedang login.
     */
    public function index(): View
    {
        $peminjamans = Peminjaman::with('detailPeminjamans.barang')
            ->where('id_peminjam', Auth::guard('peminjam')->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('peminjam.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Detail satu pengajuan peminjaman.
     */
    public function show(Peminjaman $peminjaman): View
    {
        $this->authorizeOwner($peminjaman);

        $peminjaman->load('detailPeminjamans.barang', 'admin', 'pengembalians');

        return view('peminjam.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Form pengajuan peminjaman baru.
     */
    public function create(): View
    {
        $barangs = Barang::where('stok', '>', 0)->orderBy('nama_barang')->get();

        return view('peminjam.peminjaman.create', compact('barangs'));
    }

    /**
     * Simpan pengajuan peminjaman + detail barang yang diajukan.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_rencana_kembali' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
            'keperluan' => ['required', 'string', 'max:1000'],
            'id_barang' => ['required', 'array', 'min:1'],
            'id_barang.*' => ['required', 'exists:barangs,id_barang', 'distinct'],
            'jumlah' => ['required', 'array', 'min:1'],
            'jumlah.*' => ['required', 'integer', 'min:1'],
        ]);

        // Validasi jumlah tidak melebihi stok yang tersedia saat ini.
        foreach ($validated['id_barang'] as $index => $idBarang) {
            $barang = Barang::find($idBarang);
            $jumlahDiminta = (int) $validated['jumlah'][$index];

            if (! $barang || $jumlahDiminta > $barang->stok) {
                return back()
                    ->withInput()
                    ->withErrors(['id_barang' => 'Jumlah yang diajukan untuk "' . ($barang->nama_barang ?? $idBarang) . '" melebihi stok tersedia (' . ($barang->stok ?? 0) . ').']);
            }
        }

        $peminjam = Auth::guard('peminjam')->user();

        DB::transaction(function () use ($validated, $peminjam) {
            $peminjaman = Peminjaman::create([
                'id_peminjam' => $peminjam->id_peminjam,
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_rencana_kembali' => $validated['tanggal_rencana_kembali'],
                'keperluan' => $validated['keperluan'],
                'status' => 'Diajukan',
            ]);

            foreach ($validated['id_barang'] as $index => $idBarang) {
                $peminjaman->detailPeminjamans()->create([
                    'id_barang' => $idBarang,
                    'jumlah' => $validated['jumlah'][$index],
                ]);
            }
        });

        return redirect()
            ->route('peminjam.peminjaman.index')
            ->with('status', 'Pengajuan peminjaman berhasil dikirim, menunggu verifikasi admin.');
    }

    private function authorizeOwner(Peminjaman $peminjaman): void
    {
        abort_unless(
            $peminjaman->id_peminjam === Auth::guard('peminjam')->id(),
            403
        );
    }
}
