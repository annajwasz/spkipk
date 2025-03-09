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
                'bobot' => 0.6,
            ],
            [
                'kriteria_id' => 1,
                'nama' => 'Tidak Memiliki KIP',
                'deskripsi' => 'Mahasiswa tidak memiliki Kartu Indonesia Pintar',
                'prioritas' => 2,
                'bobot' => 0.4,
            ],

            // Subkriteria untuk Tingkatan Desil (kriteria_id: 2)
            [
                'kriteria_id' => 2,
                'nama' => 'Desil 1',
                'deskripsi' => 'Tingkat kesejahteraan terendah',
                'prioritas' => 1,
                'bobot' => 0.35,
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Desil 2',
                'deskripsi' => 'Tingkat kesejahteraan sangat rendah',
                'prioritas' => 2,
                'bobot' => 0.25,
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Desil 3',
                'deskripsi' => 'Tingkat kesejahteraan rendah',
                'prioritas' => 3,
                'bobot' => 0.20,
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Desil 4',
                'deskripsi' => 'Tingkat kesejahteraan menengah bawah',
                'prioritas' => 4,
                'bobot' => 0.15,
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Desil 5',
                'deskripsi' => 'Tingkat kesejahteraan menengah',
                'prioritas' => 5,
                'bobot' => 0.05,
            ],

            // Subkriteria untuk Kondisi Ekonomi (kriteria_id: 3)
            [
                'kriteria_id' => 3,
                'nama' => 'Sangat Kurang Mampu',
                'deskripsi' => 'Penghasilan dibawah UMR',
                'prioritas' => 1,
                'bobot' => 0.4,
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Kurang Mampu',
                'deskripsi' => 'Penghasilan setara UMR',
                'prioritas' => 2,
                'bobot' => 0.3,
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Cukup Mampu',
                'deskripsi' => 'Penghasilan diatas UMR',
                'prioritas' => 3,
                'bobot' => 0.3,
            ],
        ];

        foreach ($subkriterias as $subkriteria) {
            SubKriteria::create($subkriteria);
        }
    }
}
