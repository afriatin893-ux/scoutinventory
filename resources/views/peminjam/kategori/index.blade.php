@extends('layouts.peminjam')

@section('page-title', __('Kelola Kategori Barang'))
@section('page-subtitle', __('Dashboard Peminjaman / Kelola Kategori Barang'))

@section('content')
<div class="table-responsive">
    <table class="table table-bordered align-middle bg-white">
        <thead>
            <tr>
                <th style="width: 60px;">{{ __('No') }}</th>
                <th>{{ __('Nama Kategori') }}</th>
                <th style="width: 160px;">{{ __('Jumlah Barang') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $kategori)
                <tr>
                    <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>{{ $kategori->barangs_count }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">{{ __('Belum ada kategori.') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $categories->links() }}
@endsection
