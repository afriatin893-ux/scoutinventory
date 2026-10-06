@extends('layouts.admin')

@section('page-title', __('Dashboard'))
@section('page-subtitle', __('Dashboard Admin / Grafik & Ringkasan Peminjaman'))

@section('content')

    <div class="dash-stats dash-stats-4">
        <div class="dash-stat">
            <span class="dash-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26" fill="none"
                    stroke="currentColor" stroke-width="1.8">
                    <path d="m21 8-9-5-9 5 9 5 9-5Z" />
                    <path d="M3 8v8l9 5 9-5V8" />
                    <path d="M12 13v8" />
                </svg>
            </span>
            <div>
                <div class="dash-stat-label">{{ __('Total Barang') }}</div>
                <div class="dash-stat-value">{{ $totalBarang }}</div>
            </div>
        </div>

        <div class="dash-stat dash-stat-gold">
            <span class="dash-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26" fill="none"
                    stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 7v5l3 2" />
                </svg>
            </span>
            <div>
                <div class="dash-stat-label">{{ __('Pengajuan Menunggu') }}</div>
                <div class="dash-stat-value">{{ $pengajuanMenunggu }}</div>
            </div>
        </div>

        <div class="dash-stat dash-stat-blue">
            <span class="dash-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26" fill="none"
                    stroke="currentColor" stroke-width="1.8">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                    <path d="M3 3v5h5" />
                    <path d="M12 7v5l4 2" />
                </svg>
            </span>
            <div>
                <div class="dash-stat-label">{{ __('Sedang Dipinjam') }}</div>
                <div class="dash-stat-value">{{ $sedangDipinjam }}</div>
            </div>
        </div>

        <div class="dash-stat dash-stat-danger">
            <span class="dash-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26" fill="none"
                    stroke="currentColor" stroke-width="1.8">
                    <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                    <path d="M12 9v4" />
                    <path d="M12 17h.01" />
                </svg>
            </span>
            <div>
                <div class="dash-stat-label">{{ __('Terlambat Kembali') }}</div>
                <div class="dash-stat-value">{{ $terlambatKembali }}</div>
            </div>
        </div>
    </div>

    <h2 class="dash-section-title">{{ __('Menu Cepat') }}</h2>

    <div class="dash-menu">
        <a href="{{ route('admin.peminjaman.pending') }}" class="dash-menu-card">
            <span class="dash-menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 11 12 14 22 4" />
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                </svg>
            </span>
            <div class="dash-menu-title">{{ __('Verifikasi Pengajuan') }}</div>
            <div class="dash-menu-desc">{{ __('Tinjau dan setujui pengajuan peminjaman yang masuk.') }}</div>
        </a>

        <a href="{{ route('admin.barang.create') }}" class="dash-menu-card">
            <span class="dash-menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14M5 12h14" />
                </svg>
            </span>
            <div class="dash-menu-title">{{ __('Tambah Barang') }}</div>
            <div class="dash-menu-desc">{{ __('Daftarkan barang inventaris baru ke sistem.') }}</div>
        </a>

        <a href="{{ route('admin.peminjaman.index') }}" class="dash-menu-card">
            <span class="dash-menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 6h13" />
                    <path d="M8 12h13" />
                    <path d="M8 18h13" />
                    <path d="M3 6h.01" />
                    <path d="M3 12h.01" />
                    <path d="M3 18h.01" />
                </svg>
            </span>
            <div class="dash-menu-title">{{ __('Riwayat Peminjaman') }}</div>
            <div class="dash-menu-desc">{{ __('Lihat seluruh riwayat peminjaman barang.') }}</div>
        </a>
    </div>

    <div class="panel">
        <div class="panel-header">
            {{ __('Menunggu Verifikasi') }}
            <a href="{{ route('admin.peminjaman.pending') }}" class="link-semua">{{ __('Lihat semua') }}</a>
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('Peminjam') }}</th>
                        <th>{{ __('Barang') }}</th>
                        <th style="width:110px;">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menunggu as $p)
                        <tr>
                            <td>
                                <div class="cell-primary">{{ $p->peminjam->nama }}</div>
                                <div class="cell-muted">{{ $p->created_at->translatedFormat('d M Y') }}</div>
                            </td>
                            <td class="cell-muted">
                                {{ $p->detailPeminjamans->take(2)->map(fn($d) => ($d->barang->nama_barang ?? '-') . ' × ' . $d->jumlah)->join(', ') }}
                                @if ($p->detailPeminjamans->count() > 2)
                                    {{ __('dan') }} {{ $p->detailPeminjamans->count() - 2 }} {{ __('lainnya') }}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.peminjaman.show', ['peminjaman' => $p->id_peminjaman, 'from' => 'verifikasi']) }}"
                                    class="btn btn-primary btn-sm">{{ __('Tinjau') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="table-empty">{{ __('Tidak ada pengajuan yang menunggu.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="dash-two">
        {{-- KIRI: grafik --}}
        <div class="panel">
            <div class="panel-header">{{ __('Grafik Peminjaman per Bulan') }}</div>
            <div class="panel-body">
                <div class="chart-box"><canvas id="grafikPeminjaman"></canvas></div>
            </div>
        </div>

        {{-- KANAN: barang paling sering dipinjam --}}
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
                                <td><span
                                        class="rank-badge">{{ $i + 1 }}</span>{{ $item->barang->nama_barang ?? '-' }}
                                </td>
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
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            color: '#f2e9dc'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endsection
