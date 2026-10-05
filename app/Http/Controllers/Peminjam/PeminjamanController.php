<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Admin;
use App\Notifications\PengajuanBaruMasuk;
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
    public function status(Request $request): View
    {
        // Semua pengajuan yang masih berjalan, plus yang baru ditolak
        // (supaya alasan penolakan langsung terlihat).
        $peminjamans = Peminjaman::with('detailPeminjamans.barang')
            ->where('id_peminjam', Auth::guard('peminjam')->id())
            ->whereIn('status', ['Diajukan', 'Disetujui', 'dipinjam', 'Ditolak'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('peminjam.status.index', compact('peminjamans'));
    }

    public function statusShow(Peminjaman $peminjaman): View
    {
        $this->authorizeOwner($peminjaman);
        $peminjaman->load('detailPeminjamans.barang');

        return view('peminjam.status.show', compact('peminjaman'));
    }

    public function riwayat(Request $request): View
    {
        $filter = in_array($request->f, ['selesai', 'ditolak']) ? $request->f : 'semua';

        $peminjamans = Peminjaman::with('detailPeminjamans.barang')
            ->where('id_peminjam', Auth::guard('peminjam')->id())
            ->whereIn('status', match ($filter) {
                'selesai' => ['dikembalikan'],
                'ditolak' => ['Ditolak'],
                default => ['dikembalikan', 'Ditolak'],
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('peminjam.riwayat.index', compact('peminjamans', 'filter'));
    }

    public function riwayatShow(Peminjaman $peminjaman): View
    {
        $this->authorizeOwner($peminjaman);
        $peminjaman->load('detailPeminjamans.barang', 'pengembalians');

        return view('peminjam.riwayat.show', compact('peminjaman'));
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
            'penanggung_jawab' => ['required', 'string', 'max:100'],
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
                'penanggung_jawab' => $validated['penanggung_jawab'],
                'status' => 'Diajukan',
            ]);
        Admin::all()->each(fn($admin) => $admin->notify(new PengajuanBaruMasuk($peminjaman)));

            foreach ($validated['id_barang'] as $index => $idBarang) {
                $peminjaman->detailPeminjamans()->create([
                    'id_barang' => $idBarang,
                    'jumlah' => $validated['jumlah'][$index],
                ]);
            }
        });

        return redirect()
            ->route('peminjam.status.index')
            ->with('status', 'Pengajuan peminjaman berhasil dikirim, menunggu verifikasi admin.');
    }

    /**
     * Tandai notifikasi sudah dibaca lalu buka halaman detail peminjamannya.
     */
    public function bukaNotifikasi(string $id): RedirectResponse
    {
        $notif = Auth::guard('peminjam')->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notif->markAsRead();

        $peminjaman = Peminjaman::find($notif->data['peminjaman_id'] ?? null);

        if (! $peminjaman) {
            return redirect()->route('peminjam.dashboard');
        }

        // Peminjaman yang sudah selesai/ditolak ada di halaman riwayat.
        $route = in_array($peminjaman->status, ['dikembalikan', 'Ditolak'])
            ? 'peminjam.riwayat.show'
            : 'peminjam.status.show';

        return redirect()->route($route, $peminjaman);
    }

    private function authorizeOwner(Peminjaman $peminjaman): void
    {
        abort_unless(
            $peminjaman->id_peminjam === Auth::guard('peminjam')->id(),
            403
        );
    }
}
