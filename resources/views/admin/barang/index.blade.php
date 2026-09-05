@extends('layouts.admin')

@section('page-title', __('Kelola Data Barang'))
@section('page-subtitle', __('Dashboard Admin/ Kelola Data Barang'))

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.barang.create') }}" class="btn btn-primary btn-sm">
            {{ __('+ Tambah Barang') }}
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered align-middle bg-white">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 60px;">{{ __('Foto') }}</th>
                    <th>{{ __('Kode') }}</th>
                    <th>{{ __('Nama Barang') }}</th>
                    <th>{{ __('Kategori') }}</th>
                    <th>{{ __('Stok') }}</th>
                    <th>{{ __('Kondisi') }}</th>
                    <th>{{ __('Lokasi') }}</th>
                    <th style="width: 160px;">{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangs as $barang)
                    <tr>
                        <td>{{ $loop->iteration + ($barangs->currentPage() - 1) * $barangs->perPage() }}</td>
                        <td>
                            @if ($barang->foto)
                                <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}"
                                    style="width:40px;height:40px;object-fit:cover;border-radius:.4rem;">
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>{{ $barang->kode_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $barang->stok }}</td>
                        <td>{{ $barang->kondisi }}</td>
                        <td>{{ $barang->lokasi }}</td>
                        <td>
                            <a href="{{ route('admin.barang.edit', $barang->id_barang) }}"
                                class="btn btn-outline-secondary btn-sm">{{ __('Edit') }}</a>

                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#hapusBarangModal" data-nama="{{ $barang->nama_barang }}"
                                data-action="{{ route('admin.barang.destroy', $barang->id_barang) }}">
                                {{ __('Hapus') }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">{{ __('Belum ada barang.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $barangs->links() }}
    <div class="modal fade" id="hapusBarangModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle border d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 36px; height: 36px;">
                            <span class="fst-italic">i</span>
                        </div>
                        <div>
                            <h5 class="mb-2" id="hapusBarangLabel">{{ __('Hapus Barang?') }}</h5>
                            <p class="text-muted mb-0">
                                {{ __('Barang yang dihapus tidak dapat dikembalikan. Barang yang masih memiliki riwayat peminjaman tidak bisa dihapus.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start px-4 pb-4 pt-0 border-0">
                    <form id="hapusBarangForm" method="POST" action="">
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
        document.getElementById('hapusBarangModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const nama = button.getAttribute('data-nama');
            const action = button.getAttribute('data-action');

            document.getElementById('hapusBarangLabel').textContent = 'Hapus Barang "' + nama + '"?';
            document.getElementById('hapusBarangForm').setAttribute('action', action);
        });
    </script>
@endsection
