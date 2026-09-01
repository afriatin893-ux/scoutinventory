@extends('layouts.admin')

@section('page-title', __('Kelola Kategori Barang'))
@section('page-subtitle', __('Dashboard Admin/ Dashboard & Kelola Kategori Barang'))

@section('content')
<div class="toolbar-row">
    <form method="GET" action="{{ route('admin.kategori.index') }}" class="flex-grow-1" style="max-width: 320px;">
        <input type="text" name="q" class="form-control" placeholder="{{ __('Cari Kategori...') }}"
               value="{{ request('q') }}">
    </form>

    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary text-nowrap">
        {{ __('+ Tambah Kategori') }}
    </a>
</div>

<div class="table-responsive">
    <table class="table table-bordered align-middle bg-white">
        <thead>
            <tr>
                <th style="width: 60px;">{{ __('No') }}</th>
                <th>{{ __('Nama Kategori') }}</th>
                <th style="width: 160px;">{{ __('Jumlah Barang') }}</th>
                <th style="width: 180px;">{{ __('Aksi') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $kategori)
                <tr>
                    <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>{{ $kategori->barangs_count }}</td>
                    <td>
                        <a href="{{ route('admin.kategori.edit', $kategori->id_kategori) }}"
                           class="btn btn-outline-secondary btn-sm">
                            {{ __('Edit') }}
                        </a>

                        <button type="button" class="btn btn-outline-danger btn-sm"
                                data-bs-toggle="modal" data-bs-target="#hapusKategoriModal"
                                data-nama="{{ $kategori->nama_kategori }}"
                                data-action="{{ route('admin.kategori.destroy', $kategori->id_kategori) }}">
                            {{ __('Hapus') }}
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">{{ __('Belum ada kategori.') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $categories->links() }}

<!-- Modal konfirmasi hapus -->
<div class="modal fade" id="hapusKategoriModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle border d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width: 36px; height: 36px;">
                        <span class="fst-italic">i</span>
                    </div>
                    <div>
                        <h5 class="mb-2" id="hapusKategoriLabel">{{ __('Hapus Kategori?') }}</h5>
                        <p class="text-muted mb-0">
                            {{ __('Kategori yang dihapus tidak dapat dikembalikan. Barang yang masih terdaftar pada kategori ini perlu dipindahkan terlebih dahulu.') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-start px-4 pb-4 pt-0 border-0">
                <form id="hapusKategoriForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-dark">{{ __('Ya, Hapus') }}</button>
                </form>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Batal') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('hapusKategoriModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const nama = button.getAttribute('data-nama');
        const action = button.getAttribute('data-action');

        document.getElementById('hapusKategoriLabel').textContent = 'Hapus Kategori "' + nama + '"?';
        document.getElementById('hapusKategoriForm').setAttribute('action', action);
    });
</script>
@endsection
