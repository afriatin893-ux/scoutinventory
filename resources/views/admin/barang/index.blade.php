@extends('layouts.admin')

@section('page-title', __('Kelola Data Barang'))
@section('page-subtitle', __('Dashboard Admin / Kelola Data Barang'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
        stroke-width="2">
        <path d="m21 8-9-5-9 5 9 5 9-5Z" />
        <path d="M3 8v8l9 5 9-5V8" />
        <path d="M12 13v8" />
    </svg>
@endsection

@section('content')
    <div class="toolbar-row" style="justify-content:flex-end;">
        <a href="{{ route('admin.barang.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15" fill="none"
                stroke="currentColor" stroke-width="2.4">
                <path d="M12 5v14M5 12h14" />
            </svg>
            {{ __('Tambah Barang') }}
        </a>
    </div>

    <div class="panel">
        <div class="panel-header">
            <span class="panel-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="m21 8-9-5-9 5 9 5 9-5Z" />
                    <path d="M3 8v8l9 5 9-5V8" />
                    <path d="M12 13v8" />
                </svg>
            </span>
            {{ __('Daftar Barang') }}
            <span class="panel-header-count">{{ $barangs->total() }} {{ __('barang') }}</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th style="width:60px;">{{ __('Foto') }}</th>
                        <th>{{ __('Nama Barang') }}</th>
                        <th>{{ __('Kategori') }}</th>
                        <th>{{ __('Stok') }}</th>
                        <th>{{ __('Kondisi') }}</th>
                        <th>{{ __('Lokasi') }}</th>
                        <th style="width:190px;">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangs as $barang)
                        <tr>
                            <td class="cell-muted">
                                {{ $loop->iteration + ($barangs->currentPage() - 1) * $barangs->perPage() }}</td>
                            <td>
                                @if ($barang->foto)
                                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}"
                                        class="thumb-sm">
                                @else
                                    <span class="thumb-placeholder">-</span>
                                @endif
                            </td>
                            <td class="cell-primary">{{ $barang->nama_barang }}</td>
                            <td>
                                <span class="tag-pill">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12"
                                        height="12" fill="none" stroke="currentColor" stroke-width="2.4">
                                        <path
                                            d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.24H4a1 1 0 0 0-1 1v5.59a2 2 0 0 0 .59 1.41l9.58 9.58a2 2 0 0 0 2.83 0l5.59-5.59a2 2 0 0 0 0-2.82Z" />
                                    </svg>
                                    {{ $barang->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="cell-primary">{{ $barang->stok }}</td>
                            <td>
                                @php
                                    $badgeClass = match ($barang->kondisi) {
                                        'Baik' => 'badge-good',
                                        'Rusak Ringan' => 'badge-warn',
                                        default => 'badge-bad',
                                    };
                                @endphp
                                <span class="badge-pill {{ $badgeClass }}">{{ $barang->kondisi }}</span>
                            </td>
                            <td class="cell-muted">{{ $barang->lokasi }}</td>
                            <td>
                                <a href="{{ route('admin.barang.edit', $barang->id_barang) }}"
                                    class="btn btn-outline btn-sm">{{ __('Edit') }}</a>
                                <button type="button" class="btn btn-outline-danger btn-sm btn-delete-trigger"
                                    data-nama="{{ $barang->nama_barang }}"
                                    data-action="{{ route('admin.barang.destroy', $barang->id_barang) }}"
                                    data-title="{{ __('Hapus Barang') }}"
                                    data-text="{{ __('Barang yang dihapus tidak dapat dikembalikan. Barang yang masih memiliki riwayat peminjaman tidak bisa dihapus.') }}">
                                    {{ __('Hapus') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-state">
                                <div class="empty-state-inner">
                                    <span class="empty-state-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path d="m21 8-9-5-9 5 9 5 9-5Z" />
                                            <path d="M3 8v8l9 5 9-5V8" />
                                            <path d="M12 13v8" />
                                        </svg>
                                    </span>
                                    <p class="empty-state-title">{{ __('Belum ada barang') }}</p>
                                    <p class="empty-state-text">
                                        {{ __('Tambahkan barang pertama untuk mulai mengelola inventaris gudep.') }}</p>
                                    <a href="{{ route('admin.barang.create') }}"
                                        class="btn btn-primary btn-sm">{{ __('+ Tambah Barang') }}</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-wrap">
        <div class="pagination-info">
            Menampilkan
            <strong>{{ $barangs->firstItem() }}</strong>
            -
            <strong>{{ $barangs->lastItem() }}</strong>
            dari
            <strong>{{ $barangs->total() }}</strong>
            data
        </div>

        @if ($barangs->hasPages())
            <div class="pagination-buttons">

                {{-- Previous --}}
                @if ($barangs->onFirstPage())
                    <span class="page-btn disabled">‹</span>
                @else
                    <a href="{{ $barangs->previousPageUrl() }}" class="page-btn">‹</a>
                @endif

                {{-- Nomor halaman --}}
                @foreach ($barangs->getUrlRange(1, $barangs->lastPage()) as $page => $url)
                    @if ($page == $barangs->currentPage())
                        <span class="page-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($barangs->hasMorePages())
                    <a href="{{ $barangs->nextPageUrl() }}" class="page-btn">›</a>
                @else
                    <span class="page-btn disabled">›</span>
                @endif

            </div>
        @endif
    </div>

    {{-- Confirm delete modal --}}
    <div class="modal-backdrop-custom" id="deleteModal">
        <div class="modal-box">
            <div class="modal-box-header">
                <div class="modal-box-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path
                            d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                        <path d="M12 9v4" />
                        <path d="M12 17h.01" />
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
        (function() {
            const backdrop = document.getElementById('deleteModal');
            const titleEl = document.getElementById('deleteModalTitle');
            const textEl = document.getElementById('deleteModalText');
            const form = document.getElementById('deleteModalForm');

            document.querySelectorAll('.btn-delete-trigger').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    titleEl.textContent = btn.getAttribute('data-title') + ' "' + btn.getAttribute(
                        'data-nama') + '"?';
                    textEl.textContent = btn.getAttribute('data-text');
                    form.setAttribute('action', btn.getAttribute('data-action'));
                    backdrop.classList.add('open');
                });
            });

            document.getElementById('deleteModalCancel').addEventListener('click', function() {
                backdrop.classList.remove('open');
            });
            backdrop.addEventListener('click', function(e) {
                if (e.target === backdrop) backdrop.classList.remove('open');
            });
        })();
    </script>
@endsection
