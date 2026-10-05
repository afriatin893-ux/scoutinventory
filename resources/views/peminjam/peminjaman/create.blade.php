@extends('layouts.peminjam')

@section('page-title', __('Form pengajuan'))
@section('page-subtitle', __('Isi barang, tanggal, dan keperluan. Admin akan memverifikasi pengajuanmu.'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8Z"/><path d="M14 3v5h5"/><path d="M12 12v6"/><path d="M9 15h6"/>
    </svg>
@endsection

@section('content')
    @php
        $daftarBarang = $barangs->map(fn ($b) => [
            'id' => $b->id_barang,
            'nama' => $b->nama_barang,
            'stok' => $b->stok,
        ])->values();

        $idLama = old('id_barang', (array) request('barang', ['']));
        $jumlahLama = old('jumlah', []);
        $barisAwal = collect($idLama)->map(fn ($id, $i) => [
            'id' => (string) $id,
            'jumlah' => $jumlahLama[$i] ?? '',
        ])->values();
    @endphp

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('peminjam.peminjaman.store') }}" id="formPengajuan" class="form-layout">
        @csrf

        <div class="form-main">

        <div class="panel">
            <div class="panel-header">
                <span class="panel-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/></svg>
                </span>
                {{ __('Barang yang Dipinjam') }}
            </div>
            <div class="panel-body">
                <div id="itemRows"></div>
                <button type="button" id="addRow" class="btn btn-outline btn-sm">{{ __('+ Tambah Barang') }}</button>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <span class="panel-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                </span>
                {{ __('Detail Peminjaman') }}
            </div>
            <div class="panel-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="tanggal_pinjam">{{ __('Tanggal Pinjam') }}</label>
                        <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control"
                            min="{{ now()->toDateString() }}" value="{{ old('tanggal_pinjam') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tanggal_rencana_kembali">{{ __('Tanggal Kembali') }}</label>
                        <input type="date" id="tanggal_rencana_kembali" name="tanggal_rencana_kembali" class="form-control"
                            value="{{ old('tanggal_rencana_kembali') }}" required>
                    </div>
                    <div class="form-group span-2">
                        <label class="form-label" for="keperluan">{{ __('Keperluan') }}</label>
                        <textarea id="keperluan" name="keperluan" class="form-control" rows="3"
                            placeholder="{{ __('Contoh: Untuk Kegiatan Perkemahan Sabtu Minggu') }}" required>{{ old('keperluan') }}</textarea>
                    </div>
                    <div class="form-group span-2">
                        <label class="form-label" for="penanggung_jawab">{{ __('Penanggung Jawab') }}</label>
                        <input type="text" id="penanggung_jawab" name="penanggung_jawab" class="form-control"
                            value="{{ old('penanggung_jawab') }}" required>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <aside class="panel sum-card">
            <div class="panel-header">{{ __('Ringkasan pengajuan') }}</div>
            <div class="panel-body">
                <ul id="sumList" class="sum-list"></ul>
                <p class="sum-note" id="sumNote">{{ __('Kamu akan dapat notifikasi saat admin selesai memverifikasi.') }}</p>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                    {{ __('Kirim pengajuan') }}
                </button>
            </div>
        </aside>
    </form>

    <script>
        const daftarBarang = @json($daftarBarang);
        const barisAwal = @json($barisAwal);
        const rows = document.getElementById('itemRows');

        function tambahBaris(id = '', jumlah = '') {
            const row = document.createElement('div');
            row.className = 'item-line';

            const sel = document.createElement('select');
            sel.name = 'id_barang[]';
            sel.className = 'form-select';
            sel.required = true;
            sel.add(new Option('-- Pilih Barang --', ''));
            daftarBarang.forEach(b => sel.add(new Option(b.nama + ' (stok: ' + b.stok + ')', b.id)));
            sel.value = String(id);

            const qty = document.createElement('input');
            qty.type = 'number';
            qty.name = 'jumlah[]';
            qty.className = 'form-control';
            qty.min = 1;
            qty.placeholder = 'Jumlah';
            qty.required = true;
            qty.value = jumlah;

            const batasiStok = () => {
                const b = daftarBarang.find(x => String(x.id) === sel.value);
                qty.max = b ? b.stok : '';
            };
            sel.addEventListener('change', batasiStok);
            batasiStok();

            const del = document.createElement('button');
            del.type = 'button';
            del.className = 'btn btn-outline-danger btn-sm remove-row';
            del.innerHTML = '&times;';

            row.append(sel, qty, del);
            rows.appendChild(row);
        }

        barisAwal.forEach(b => tambahBaris(b.id, b.jumlah));
        if (!rows.children.length) tambahBaris();

        document.getElementById('addRow').addEventListener('click', () => tambahBaris());
        rows.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row') && rows.children.length > 1) {
                e.target.closest('.item-line').remove();
            }
        });

        const tglPinjam = document.getElementById('tanggal_pinjam');
        const tglKembali = document.getElementById('tanggal_rencana_kembali');
        tglKembali.min = tglPinjam.value || '';
        tglPinjam.addEventListener('change', () => { tglKembali.min = tglPinjam.value; });

        function ringkas() {
            const ul = document.getElementById('sumList');
            ul.innerHTML = '';
            rows.querySelectorAll('.item-line').forEach(r => {
                const sel = r.querySelector('select'), qty = r.querySelector('input');
                if (!sel.value) return;
                const li = document.createElement('li');
                li.textContent = sel.options[sel.selectedIndex].text.replace(/ \(stok:.*\)/, '') + ' × ' + (qty.value || '?');
                ul.appendChild(li);
            });
            if (!ul.children.length) ul.innerHTML = '<li class="sum-empty">Belum ada barang dipilih</li>';
            if (tglPinjam.value && tglKembali.value) {
                const hari = Math.round((new Date(tglKembali.value) - new Date(tglPinjam.value)) / 864e5) + 1;
                document.getElementById('sumNote').textContent = 'Pinjam ' + tglPinjam.value + ' s/d ' + tglKembali.value + ' (' + hari + ' hari). Kamu akan dapat notifikasi saat admin selesai memverifikasi.';
            }
        }
        document.getElementById('formPengajuan').addEventListener('input', ringkas);
        document.getElementById('formPengajuan').addEventListener('click', () => setTimeout(ringkas));
        ringkas();
        // pilihan dari katalog sudah terpakai, kosongkan
        try { sessionStorage.removeItem('pilihanBarang'); } catch (e) {}

        document.getElementById('formPengajuan').addEventListener('submit', function (e) {
            const btn = e.target.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.textContent = 'Mengirim...';
        });
    </script>
@endsection
