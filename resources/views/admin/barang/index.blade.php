@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Kelola Data Barang') }}
                    <a href="{{ route('admin.barang.create') }}" class="btn btn-primary btn-sm">
                        {{ __('+ Tambah Barang') }}
                    </a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                    @endif

                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
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
                                            <img src="{{ asset('storage/'.$barang->foto) }}" alt="{{ $barang->nama_barang }}" style="width:40px;height:40px;object-fit:cover;border-radius:.4rem;">
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
                                        <a href="{{ route('admin.barang.edit', $barang->id_barang) }}" class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
                                        <form action="{{ route('admin.barang.destroy', $barang->id_barang) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">{{ __('Hapus') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center">{{ __('Belum ada barang.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $barangs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
