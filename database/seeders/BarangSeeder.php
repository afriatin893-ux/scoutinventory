<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barang = [
            [
                'id_kategori' => 1,
                'kode_barang' => 'BRG001',
                'nama_barang' => 'Tenda Pleton',
                'stok' => 10,
                'kondisi' => 'Baik',
                'lokasi' => 'Sanggar Pramuka',
                'tanggal_pengadaan' => '2025-01-10',
            ],
            [
                'id_kategori' => 1,
                'kode_barang' => 'BRG002',
                'nama_barang' => 'Tenda Pleton',
                'stok' => 8,
                'kondisi' => 'Baik',
                'lokasi' => 'Sanggar Pramuka',
                'tanggal_pengadaan' => '2025-02-15',
            ],
            [
                'id_kategori' => 2,
                'kode_barang' => 'BRG003',
                'nama_barang' => 'Kompor Lapangan',
                'stok' => 5,
                'kondisi' => 'Baik',
                'lokasi' => 'Sanggar Pramuka',
                'tanggal_pengadaan' => '2025-03-10',
            ],
            [
                'id_kategori' => 2,
                'kode_barang' => 'BRG004',
                'nama_barang' => 'Tongkat',
                'stok' => 10,
                'kondisi' => 'Baik',
                'lokasi' => 'Sanggar Pramuka',
                'tanggal_pengadaan' => '2025-03-10',
            ],
            [
                'id_kategori' => 4,
                'kode_barang' => 'BRG005',
                'nama_barang' => 'Tali Pramuka',
                'stok' => 20,
                'kondisi' => 'Baik',
                'lokasi' => 'Sanggar Pramuka',
                'tanggal_pengadaan' => '2025-04-05',
            ],
        ];

        foreach ($barang as $dataBarang) {
            Barang::create($dataBarang);
        }
    }
}
