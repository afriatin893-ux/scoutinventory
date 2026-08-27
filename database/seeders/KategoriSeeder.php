<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            'Peralatan Kemah',
            'Peralatan Masak',
            'Perlengkapan Tidur',
            'Tali dan Pionering',
            'Peralatan Navigasi',
            'Peralatan P3K',
            'Perlengkapan Api Unggun',
            'Peralatan Kebersihan',
            'Perlengkapan Kegiatan',
            'Perlengkapan Survival',
        ];

        foreach ($kategori as $namaKategori) {
            Kategori::create([
                'nama_kategori' => $namaKategori,
            ]);
        }
    }
}
