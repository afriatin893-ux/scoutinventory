@extends('layouts.peminjam')

@section('page-title', __('Form Pengajuan Peminjaman'))
@section('page-subtitle', __('Dashboard Peminjam/ Form Pengajuan Peminjaman'))

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('peminjam.peminjaman.store') }}">
                @csrf

                <div id="itemRows">
                    <div class="row g-2 mb-2 item-row">
                        <div class="col-md-7">
                            <label class="form-label">{{ __('Pilih Barang') }}</label>
                            <select name="id_barang[]" class="form-select" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->id_barang }}">
                                        {{ $barang->nama_barang }} (stok: {{ $barang->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('Jumlah') }}</label>
                            <input type="number" name="jumlah[]" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-row">&times;</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="addRow" class="btn btn-outline-secondary btn-sm mb-3">
                    {{ __('+ Tambah Barang') }}
                </button>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Tanggal Pinjam') }}</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam') }}"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Tanggal Kembali') }}</label>
                        <input type="date" name="tanggal_rencana_kembali" class="form-control"
                            value="{{ old('tanggal_rencana_kembali') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Keperluan') }}</label>
                    <textarea name="keperluan" class="form-control" rows="3"
                        placeholder="{{ __('Contoh: Untuk Kegiatan Perkemahan Sabtu Minggu') }}" required>{{ old('keperluan') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Ajukan Peminjaman') }}</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('addRow').addEventListener('click', function() {
            const rows = document.getElementById('itemRows');
            rows.insertAdjacentHTML('beforeend', rows.firstElementChild.outerHTML);
        });
        document.getElementById('itemRows').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row') && document.querySelectorAll('.item-row').length > 1) {
                e.target.closest('.item-row').remove();
            }
        });
    </script>
@endsection
