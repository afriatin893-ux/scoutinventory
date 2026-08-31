@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Kelola Kategori') }}
                    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary btn-sm">
                        {{ __('+ Tambah Kategori') }}
                    </a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>{{ __('Nama Kategori') }}</th>
                                <th style="width: 120px;">{{ __('Jumlah Barang') }}</th>
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
                                        <a href="{{ route('admin.kategori.edit', $kategori->id_kategori) }}" class="btn btn-warning btn-sm">
                                            {{ __('Edit') }}
                                        </a>

                                        <form action="{{ route('admin.kategori.destroy', $kategori->id_kategori) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                {{ __('Hapus') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">{{ __('Belum ada kategori.') }}</td>
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
