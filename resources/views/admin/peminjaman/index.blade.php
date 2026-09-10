@extends('layouts.admin')

@section('page-title', __('Riwayat Peminjaman'))
@section('page-subtitle', __('Dashboard Admin/ Riwayat Peminjaman'))

@section('content')
    <div class="toolbar-row mb-3">
        <form method="GET" action="{{ route('admin.peminjaman.index') }}">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">{{ __('Semua Status') }}</option>
                @foreach (['Diajukan', 'Disetujui', 'dipinjam', 'Ditolak', 'dikembalikan'] as $status)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle bg-white">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Barang</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Rencana Kembali</th>
                    <th>Status</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ $loop->iteration + ($peminjamans->currentPage() - 1) * $peminjamans->perPage() }}</td>
                        <td>{{ $peminjaman->peminjam->nama }}</td>
                        <td>{{ $peminjaman->detailPeminjamans->pluck('barang.nama_barang')->join(', ') }}</td>
                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($peminjaman->status) }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.peminjaman.show', $peminjaman->id_peminjaman) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    Detail
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#hapusRiwayatModal" data-peminjam="{{ $peminjaman->peminjam->nama }}"
                                    data-action="{{ route('admin.peminjaman.destroy', $peminjaman->id_peminjaman) }}">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $peminjamans->links() }}
    <!-- Modal konfirmasi hapus -->
    <div class="modal fade" id="hapusRiwayatModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle border d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 36px; height: 36px;">
                            <span class="fst-italic">i</span>
                        </div>
                        <div>
                            <h5 class="mb-2" id="hapusRiwayatLabel">{{ __('Hapus Riwayat?') }}</h5>
                            <p class="text-muted mb-0">
                                {{ __('Data peminjaman ini akan dihapus permanen beserta riwayat pengembaliannya.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start px-4 pb-4 pt-0 border-0">
                    <form id="hapusRiwayatForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-dark">{{ __('Ya, Hapus') }}</button>
                    </form>
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">{{ __('Batal') }}</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('hapusRiwayatModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const peminjam = button.getAttribute('data-peminjam');
            const action = button.getAttribute('data-action');

            document.getElementById('hapusRiwayatLabel').textContent = 'Hapus Riwayat "' + peminjam + '"?';
            document.getElementById('hapusRiwayatForm').setAttribute('action', action);
        });
    </script>
@endsection
