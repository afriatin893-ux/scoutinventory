@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Daftar Barang Tersedia') }}
                    <a href="{{ route('peminjam.peminjaman.create') }}" class="btn btn-primary btn-sm">
                        {{ __('+ Ajukan Peminjaman') }}
                    </a>
                </div>

                <div class="card-body">
                    <form method="GET" class="row g-2 mb-3">
                        <div class="col-auto">
                            <select name="id_kategori" class="form-select" onchange="this.form.submit()">
                                <option value="">{{ __('Semua Kategori') }}</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ request('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 60px;">{{ __('Foto') }}</th>
                                <th>{{ __('Nama Barang') }}</th>
                                <th>{{ __('Kategori') }}</th>
                                <th>{{ __('Stok Tersedia') }}</th>
                                <th>{{ __('Kondisi') }}</th>
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
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                                    <td>{{ $barang->stok }}</td>
                                    <td>{{ $barang->kondisi }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center">{{ __('Belum ada barang.') }}</td></tr>
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
