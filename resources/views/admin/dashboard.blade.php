@extends('layouts.admin')

@section('page-title', __('Dashboard'))
@section('page-subtitle', __('Dashboard Admin / Grafik & Ringkasan Peminjaman'))

@section('content')
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/>
                </svg>
            </div>
            <div class="stat-label">{{ __('Total Barang') }}</div>
            <div class="stat-value">{{ $totalBarang }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>
                </svg>
            </div>
            <div class="stat-label">{{ __('Pengajuan Menunggu') }}</div>
            <div class="stat-value">{{ $pengajuanMenunggu }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/>
                </svg>
            </div>
            <div class="stat-label">{{ __('Sedang Dipinjam') }}</div>
            <div class="stat-value">{{ $sedangDipinjam }}</div>
        </div>

        <div class="stat-card danger">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/>
                    <path d="M12 9v4"/><path d="M12 17h.01"/>
                </svg>
            </div>
            <div class="stat-label">{{ __('Terlambat Kembali') }}</div>
            <div class="stat-value">{{ $terlambatKembali }}</div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">{{ __('Grafik Peminjaman per Bulan') }}</div>
        <div class="panel-body">
            <canvas id="grafikPeminjaman" height="90"></canvas>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">{{ __('Barang Paling Sering Dipinjam') }}</div>
        <div class="panel-body" style="padding-top:0;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('Barang') }}</th>
                        <th>{{ __('Total Dipinjam') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangTerpopuler as $i => $item)
                        <tr>
                            <td><span class="rank-badge">{{ $i + 1 }}</span>{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $item->total_dipinjam }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="table-empty">{{ __('Belum ada data peminjaman.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('grafikPeminjaman'), {
            type: 'bar',
            data: {
                labels: @json($labelBulan),
                datasets: [{
                    label: '{{ __('Jumlah Peminjaman') }}',
                    data: @json($dataGrafik),
                    backgroundColor: '#7a4a22',
                    borderRadius: 6,
                    maxBarThickness: 42
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f2e9dc' } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
@endsection
