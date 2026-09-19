@extends('layouts.admin')

@section('page-title', __('Riwayat Peminjaman'))
@section('page-subtitle', __('Dashboard Admin / Riwayat Peminjaman'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/>
    </svg>
@endsection

@section('content')
    <div class="toolbar-row" style="justify-content:flex-end;">
        <form method="GET" action="{{ route('admin.peminjaman.index') }}">
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">{{ __('Semua Status') }}</option>
                @foreach (['Diajukan', 'Disetujui', 'dipinjam', 'Ditolak', 'dikembalikan'] as $status)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="panel">
        <div class="panel-header">
            <span class="panel-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/></svg>
            </span>
            {{ __('Semua Peminjaman') }}
            <span class="panel-header-count">{{ $peminjamans->total() }} {{ __('data') }}</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:50px;">{{ __('No') }}</th>
                        <th>{{ __('Peminjam') }}</th>
                        <th>{{ __('Barang') }}</th>
                        <th>{{ __('Tgl Pinjam') }}</th>
                        <th>{{ __('Tgl Rencana Kembali') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th style="width:170px;">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamans as $peminjaman)
                        @php
                            $statusBadge = match($peminjaman->status) {
                                'Diajukan' => 'badge-warn',
                                'Disetujui' => 'badge-info',
                                'dipinjam' => 'badge-good',
                                'Ditolak', 'ditolak' => 'badge-bad',
                                'dikembalikan' => 'badge-good',
                                default => 'badge-info',
                            };
                        @endphp
                        <tr>
                            <td class="cell-muted">{{ $loop->iteration + ($peminjamans->currentPage() - 1) * $peminjamans->perPage() }}</td>
                            <td class="cell-primary">{{ $peminjaman->peminjam->nama }}</td>
                            <td class="cell-muted">{{ $peminjaman->detailPeminjamans->pluck('barang.nama_barang')->join(', ') }}</td>
                            <td class="cell-muted">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                            <td class="cell-muted">{{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</td>
                            <td><span class="badge-pill {{ $statusBadge }}">{{ ucfirst($peminjaman->status) }}</span></td>
                            <td>
                                <a href="{{ route('admin.peminjaman.show', $peminjaman->id_peminjaman) }}" class="btn btn-outline btn-sm">
                                    {{ __('Detail') }}
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm btn-delete-trigger"
                                        data-nama="{{ $peminjaman->peminjam->nama }}"
                                        data-action="{{ route('admin.peminjaman.destroy', $peminjaman->id_peminjaman) }}"
                                        data-title="{{ __('Hapus Riwayat') }}"
                                        data-text="{{ __('Data peminjaman ini akan dihapus permanen beserta riwayat pengembaliannya.') }}">
                                    {{ __('Hapus') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="empty-state-inner">
                                    <span class="empty-state-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/>
                                        </svg>
                                    </span>
                                    <p class="empty-state-title">{{ __('Belum ada riwayat peminjaman') }}</p>
                                    <p class="empty-state-text">{{ __('Riwayat peminjaman yang sudah diproses akan muncul di sini.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-wrap">{{ $peminjamans->links() }}</div>

    {{-- Confirm delete modal --}}
    <div class="modal-backdrop-custom" id="deleteModal">
        <div class="modal-box">
            <div class="modal-box-header">
                <div class="modal-box-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/><path d="M12 9v4"/><path d="M12 17h.01"/>
                    </svg>
                </div>
                <div>
                    <h3 class="modal-box-title" id="deleteModalTitle">{{ __('Hapus data?') }}</h3>
                    <p class="modal-box-text" id="deleteModalText"></p>
                </div>
            </div>
            <form id="deleteModalForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-box-actions">
                    <button type="submit" class="btn-danger-solid">{{ __('Ya, Hapus') }}</button>
                    <button type="button" class="btn btn-outline" id="deleteModalCancel">{{ __('Batal') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    (function () {
        const backdrop = document.getElementById('deleteModal');
        const titleEl = document.getElementById('deleteModalTitle');
        const textEl = document.getElementById('deleteModalText');
        const form = document.getElementById('deleteModalForm');

        document.querySelectorAll('.btn-delete-trigger').forEach(function (btn) {
            btn.addEventListener('click', function () {
                titleEl.textContent = btn.getAttribute('data-title') + ' "' + btn.getAttribute('data-nama') + '"?';
                textEl.textContent = btn.getAttribute('data-text');
                form.setAttribute('action', btn.getAttribute('data-action'));
                backdrop.classList.add('open');
            });
        });

        document.getElementById('deleteModalCancel').addEventListener('click', function () {
            backdrop.classList.remove('open');
        });
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) backdrop.classList.remove('open');
        });
    })();
</script>
@endsection
