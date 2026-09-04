@extends('layouts.admin')

@section('page-title', __('Dashboard'))
@section('page-subtitle', __('Dashboard Admin/ Dashboard & Grafik Peminjaman'))

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

<div class="card mb-4">
    <div class="card-header">{{ __('Grafik Peminjaman per Bulan') }}</div>
    <div class="card-body">
        <canvas id="grafikPeminjaman" height="90"></canvas>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('grafikPeminjaman'), {
        type: 'bar',
        data: {
            labels: @json($labelBulan),
            datasets: [{
                label: '{{ __("Jumlah Peminjaman") }}',
                data: @json($dataGrafik),
                backgroundColor: '#c0673a'
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
</script>
@endsection
