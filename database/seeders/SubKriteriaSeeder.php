<?php

namespace Database\Seeders;

use App\Models\SubKriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subkriterias = [
            // Subkriteria untuk Kepemilikan KIP (kriteria_id: 1)
            [
                'kriteria_id' => 1,
                'nama' => 'Memiliki KIP',
                'deskripsi' => 'Mahasiswa memiliki Kartu Indonesia Pintar',
                'prioritas' => 1,
                'bobot' => 0.3906250,
            ],
            [
                'kriteria_id' => 1,
                'nama' => 'Tidak Memiliki KIP',
                'deskripsi' => 'Mahasiswa tidak memiliki Kartu Indonesia Pintar',
                'prioritas' => 2,
                'bobot' => 0.1302083,
            ],

            // Subkriteria untuk Tingkatan Desil (kriteria_id: 2)
            [
                'kriteria_id' => 2,
                'nama' => 'Desil 1',
                'deskripsi' => 'Tingkat kesejahteraan terendah',
                'prioritas' => 1,
                'bobot' => 0.1238805,
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Desil 2',
                'deskripsi' => 'Tingkat kesejahteraan sangat rendah',
                'prioritas' => 2,
                'bobot' => 0.0695139,
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Desil 3',
                'deskripsi' => 'Tingkat kesejahteraan rendah',
                'prioritas' => 3,
                'bobot' => 0.0424306,
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Desil 4',
                'deskripsi' => 'Tingkat kesejahteraan menengah bawah',
                'prioritas' => 4,
                'bobot' => 0.0243750,
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Desil 5',
                'deskripsi' => 'Tingkat kesejahteraan menengah',
                'prioritas' => 5,
                'bobot' => 0.0108333,
            ],

            // Subkriteria untuk Kondisi Ekonomi (kriteria_id: 3)
            [
                'kriteria_id' => 3,
                'nama' => 'Sangat Kurang Mampu',
                'deskripsi' => 'Memiliki lebih dari 2 bantuan pemerintah',
                'prioritas' => 1,
                'bobot' => 0.0759548,
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Kurang Mampu',
                'deskripsi' => 'Memiliki 2 bantuan pemerintah',
                'prioritas' => 2,
                'bobot' => 0.0394965,
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Cukup Mampu',
                'deskripsi' => 'Mahasiswa memiliki 1 bantuan pemerintah',
                'prioritas' => 3,
                'bobot' => 0.0212674,
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Tidak Menerima Bantuan',
                'deskripsi' => 'Mahasiswa tidak memiliki bantuan pemerintah',
                'prioritas' => 4,
                'bobot' => 0.0091146,
            ],

            // Subkriteria untuk Status Orang Tua (kriteria_id: 4)
            [
                'kriteria_id' => 4,
                'nama' => 'Kedua Orang Tua Wafat',
                'deskripsi' => 'Ayah dan Ibu wafat',
                'prioritas' => 1,
                'bobot' => 0.0381944,
            ],
            [
                'kriteria_id' => 4,
                'nama' => 'Salah Satu Orang Tua Wafat',
                'deskripsi' => 'Ayah atau Ibu-nya wafat',
                'prioritas' => 2,
                'bobot' => 0.0173611,
            ],
            [
                'kriteria_id' => 4,
                'nama' => 'Kedua Orang Tua Masih Hidup',
                'deskripsi' => 'Ayah dan Ibu-nya masih hidup',
                'prioritas' => 3,
                'bobot' => 0.0069444,
            ],
        ];

        foreach ($subkriterias as $subkriteria) {
            SubKriteria::create($subkriteria);
        }
    }
}
