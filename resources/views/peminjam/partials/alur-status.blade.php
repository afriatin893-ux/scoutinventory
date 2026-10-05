{{--
    Alur status peminjaman: Diajukan > Diverifikasi (Disetujui/Ditolak) > Dipinjam > Dikembalikan
    Pemakaian: @include('peminjam.partials.alur-status', ['peminjaman' => $peminjaman])
--}}
@php
    $status = strtolower($peminjaman->status);

    // [kelas, keterangan kecil] untuk tiap tahap
    $tahap = [
        'Diajukan'     => ['done', null],
        'Diverifikasi' => match ($status) {
            'diajukan' => ['wait', 'Menunggu admin'],
            'ditolak'  => ['reject', 'Ditolak'],
            default    => ['done', 'Disetujui'],
        },
        'Dipinjam'     => match ($status) {
            'disetujui'             => ['now', 'Menunggu diambil'],
            'dipinjam', 'dikembalikan' => ['done', null],
            default                 => ['', null],
        },
        'Dikembalikan' => match ($status) {
            'dipinjam'     => ['now', null],
            'dikembalikan' => ['done', null],
            default        => ['', null],
        },
    ];
    $i = 0;
@endphp

<div class="alur" role="list" aria-label="Alur status peminjaman">
    @foreach ($tahap as $nama => $info)
        @php [$kelas, $sub] = $info; @endphp
        <div class="alur-step {{ $kelas }}" role="listitem">
            <i></i>{{ $nama }}
            @if ($sub)<span class="sub">{{ $sub }}</span>@endif
        </div>
        @if (++$i < 4)
            <div class="alur-line {{ $kelas === 'done' ? 'done' : '' }}"></div>
        @endif
    @endforeach
</div>
