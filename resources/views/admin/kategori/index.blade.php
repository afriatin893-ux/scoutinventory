@extends('layouts.admin')

@section('page-title', __('Kelola Kategori Barang'))
@section('page-subtitle', __('Dashboard Admin / Kelola Kategori Barang'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
        stroke-width="2">
        <path
            d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.24H4a1 1 0 0 0-1 1v5.59a2 2 0 0 0 .59 1.41l9.58 9.58a2 2 0 0 0 2.83 0l5.59-5.59a2 2 0 0 0 0-2.82Z" />
        <circle cx="7.5" cy="7.5" r="1.2" />
    </svg>
@endsection

@section('content')
    <div class="toolbar-row">
        <form method="GET" action="{{ route('admin.kategori.index') }}">
            <div class="search-input">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="7" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" name="q" placeholder="{{ __('Cari Kategori...') }}" value="{{ request('q') }}">
            </div>
        </form>

        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15" fill="none"
                stroke="currentColor" stroke-width="2.4">
                <path d="M12 5v14M5 12h14" />
            </svg>
            {{ __('Tambah Kategori') }}
        </a>
    </div>

    <div class="panel">
        <div class="panel-header">
            <span class="panel-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path
                        d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.24H4a1 1 0 0 0-1 1v5.59a2 2 0 0 0 .59 1.41l9.58 9.58a2 2 0 0 0 2.83 0l5.59-5.59a2 2 0 0 0 0-2.82Z" />
                    <circle cx="7.5" cy="7.5" r="1.2" />
                </svg>
            </span>
            {{ __('Daftar Kategori') }}
            <span class="panel-header-count">{{ $categories->total() }} {{ __('kategori') }}</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:60px;">{{ __('No') }}</th>
                        <th>{{ __('Nama Kategori') }}</th>
                        <th style="width:160px;">{{ __('Jumlah Barang') }}</th>
                        <th style="width:190px;">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $kategori)
                        <tr>
                            <td class="cell-muted">
                                {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                            <td class="cell-primary">{{ $kategori->nama_kategori }}</td>
                            <td>
                                <span class="tag-pill">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12"
                                        height="12" fill="none" stroke="currentColor" stroke-width="2.4">
                                        <path d="m21 8-9-5-9 5 9 5 9-5Z" />
                                        <path d="M3 8v8l9 5 9-5V8" />
                                    </svg>
                                    {{ $kategori->barangs_count }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.kategori.edit', $kategori->id_kategori) }}"
                                    class="btn btn-outline btn-sm">
                                    {{ __('Edit') }}
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm btn-delete-trigger"
                                    data-nama="{{ $kategori->nama_kategori }}"
                                    data-action="{{ route('admin.kategori.destroy', $kategori->id_kategori) }}"
                                    data-title="{{ __('Hapus Kategori') }}"
                                    data-text="{{ __('Kategori yang dihapus tidak dapat dikembalikan. Barang yang masih terdaftar pada kategori ini perlu dipindahkan terlebih dahulu.') }}">
                                    {{ __('Hapus') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">
                                <div class="empty-state-inner">
                                    <span class="empty-state-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path
                                                d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.24H4a1 1 0 0 0-1 1v5.59a2 2 0 0 0 .59 1.41l9.58 9.58a2 2 0 0 0 2.83 0l5.59-5.59a2 2 0 0 0 0-2.82Z" />
                                        </svg>
                                    </span>
                                    <p class="empty-state-title">{{ __('Belum ada kategori') }}</p>
                                    <p class="empty-state-text">
                                        {{ __('Buat kategori pertama untuk mulai mengelompokkan barang inventaris.') }}</p>
                                    <a href="{{ route('admin.kategori.create') }}"
                                        class="btn btn-primary btn-sm">{{ __('+ Tambah Kategori') }}</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-wrap">{{ $categories->links() }}</div>

    {{-- Confirm delete modal (self-contained, no Bootstrap JS) --}}
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
