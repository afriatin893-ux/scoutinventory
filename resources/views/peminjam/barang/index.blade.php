@extends('layouts.peminjam')

@section('page-title', __('Katalog barang'))
@section('page-subtitle', $totalSemua . ' ' . __('jenis barang dari') . ' ' . $categories->count() . ' ' . __('kategori. Pilih yang kamu butuhkan, lalu ajukan sekaligus.'))

@section('content')
    <form method="GET" class="katalog-tool">
        @if (request('id_kategori'))
            <input type="hidden" name="id_kategori" value="{{ request('id_kategori') }}">
        @endif
        <input type="search" name="q" value="{{ request('q') }}" class="form-control"
            placeholder="{{ __('Cari nama barang, misalnya tenda atau tali') }}" aria-label="{{ __('Cari barang') }}">
        <select name="urut" class="filter-select" aria-label="{{ __('Urutkan') }}" onchange="this.form.submit()">
            <option value="">{{ __('Urutkan: Nama A-Z') }}</option>
            <option value="stok" {{ request('urut') === 'stok' ? 'selected' : '' }}>{{ __('Stok terbanyak') }}</option>
        </select>
        <button type="submit" class="btn btn-primary">{{ __('Cari') }}</button>
    </form>

    <div class="chips">
        <a href="{{ route('peminjam.barang.index', array_filter(['q' => request('q'), 'urut' => request('urut')])) }}"
            class="chip {{ request('id_kategori') ? '' : 'on' }}">{{ __('Semua') }}<em>{{ $totalSemua }}</em></a>
        @foreach ($categories as $kategori)
            <a href="{{ route('peminjam.barang.index', array_filter(['id_kategori' => $kategori->id_kategori, 'q' => request('q'), 'urut' => request('urut')])) }}"
                class="chip {{ request('id_kategori') == $kategori->id_kategori ? 'on' : '' }}">
                {{ $kategori->nama_kategori }}<em>{{ $kategori->barangs_count }}</em>
            </a>
        @endforeach
    </div>

    <p class="hasil-info">{{ $barangs->total() }} {{ __('barang ditemukan') }}</p>

    @if ($barangs->count())
        <div class="catalog-grid">
            @foreach ($barangs as $barang)
                @php
                    $habis = $barang->stok < 1;
                    $sisaSedikit = ! $habis && $barang->stok <= 1;
                @endphp
                <article class="catalog-card" data-id="{{ $barang->id_barang }}">
                    <div class="catalog-photo">
                        @if ($barang->foto)
                            <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="34" height="34" fill="none" stroke="currentColor" stroke-width="1.6"><path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/></svg>
                        @endif
                    </div>
                    <div class="catalog-body">
                        <div class="catalog-name">{{ $barang->nama_barang }}</div>
                        <div class="catalog-meta">{{ $barang->kategori->nama_kategori ?? '-' }}@if ($barang->lokasi) &middot; {{ $barang->lokasi }}@endif</div>
                        <div class="catalog-foot">
                            <span class="stok-tag {{ $habis ? 'out' : ($sisaSedikit ? 'low' : '') }}">
                                {{ $habis ? __('Habis') : ($sisaSedikit ? __('Sisa') . ' ' . $barang->stok : __('Tersedia') . ' ' . $barang->stok) }}
                            </span>
                            @if ($habis)
                                <span class="pilih-btn" aria-disabled="true">{{ __('Pinjam') }}</span>
                            @else
                                <button type="button" class="pilih-btn" data-pilih="{{ $barang->id_barang }}">{{ __('Pinjam') }}</button>
                            @endif
                        </div>
                        @if ($barang->kondisi && $barang->kondisi !== 'Baik')
                            <div class="catalog-meta">{{ __('Kondisi:') }} {{ $barang->kondisi }}</div>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="panel">
            <div class="panel-body" style="text-align:center;">
                <p class="empty-state-title">{{ __('Tidak ada barang yang cocok') }}</p>
                <p class="empty-state-text">{{ __('Coba kata kunci lain atau pilih kategori Semua.') }}</p>
            </div>
        </div>
    @endif

    <div class="pagination-wrap">{{ $barangs->links() }}</div>

    <div class="cart-bar" id="cartBar" hidden>
        <span id="cartText"></span>
        <button type="button" class="cart-clear" id="cartClear">{{ __('Kosongkan') }}</button>
        <a href="#" class="btn-hero" id="cartGo">{{ __('Lanjut ke form pengajuan') }}</a>
    </div>
@endsection

@section('scripts')
<script>
    // Pilihan barang disimpan di sessionStorage supaya tetap ada saat pindah halaman/filter.
    (function () {
        const KEY = 'pilihanBarang';
        const base = @json(route('peminjam.peminjaman.create'));
        const load = () => { try { return JSON.parse(sessionStorage.getItem(KEY)) || []; } catch (e) { return []; } };
        const save = (v) => { try { sessionStorage.setItem(KEY, JSON.stringify(v)); } catch (e) {} };
        const bar = document.getElementById('cartBar');

        function render() {
            const ids = load();
            document.querySelectorAll('[data-pilih]').forEach(btn => {
                const on = ids.includes(btn.dataset.pilih);
                btn.classList.toggle('on', on);
                btn.textContent = on ? 'Dipilih ✓' : 'Pinjam';
                btn.closest('.catalog-card').classList.toggle('sel', on);
            });
            bar.hidden = ids.length === 0;
            document.getElementById('cartText').textContent = ids.length + ' barang dipilih';
            document.getElementById('cartGo').href = base + '?' + ids.map(i => 'barang[]=' + encodeURIComponent(i)).join('&');
        }

        document.addEventListener('click', function (e) {
            const btn = e.target.closest('[data-pilih]');
            if (btn) {
                let ids = load();
                ids = ids.includes(btn.dataset.pilih) ? ids.filter(i => i !== btn.dataset.pilih) : ids.concat(btn.dataset.pilih);
                save(ids); render();
            }
            if (e.target.id === 'cartClear') { save([]); render(); }
        });
        render();
    })();
</script>
@endsection
