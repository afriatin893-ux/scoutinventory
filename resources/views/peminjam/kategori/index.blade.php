@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Daftar Kategori Barang') }}</div>

                <div class="card-body">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>{{ __('Nama Kategori') }}</th>
                                <th style="width: 140px;">{{ __('Jumlah Barang') }}</th>
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

                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
