@extends('layouts.admin')

@section('page-title', __('Dashboard'))
@section('page-subtitle', __('Dashboard Admin'))

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted small">{{ __('Total Barang') }}</div>
                    <div class="fs-3 fw-bold">{{ $totalBarang }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted small">{{ __('Pengajuan Menunggu') }}</div>
                    <div class="fs-3 fw-bold">{{ $pengajuanMenunggu }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted small">{{ __('Sedang Dipinjam') }}</div>
                    <div class="fs-3 fw-bold">{{ $sedangDipinjam }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted small">{{ __('Terlambat Kembali') }}</div>
                    <div class="fs-3 fw-bold text-danger">{{ $terlambatKembali }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
