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
                'bobot' => 0.3425000,
            ],
            [
                'kriteria_id' => 1,
                'nama' => 'Tidak Memiliki KIP',
                'deskripsi' => 'Mahasiswa tidak memiliki Kartu Indonesia Pintar',
                'prioritas' => 2,
                'bobot' => 0.1141667,
            ],
            // Subkriteria untuk Terdata dalam DTKS (kriteria_id: 2)
            [
                'kriteria_id' => 2,
                'nama' => 'Terdata',
                'deskripsi' => 'Mahasiswa yang datanya tercatat dalam Data Terpadu Kesejahteraan Sosial (DTKS).',
                'prioritas' => 1,
                'bobot' => 0.1925000,
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Tidak Terdata',
                'deskripsi' => 'Mahasiswa yang datanya tidak tercatat dalam Data Terpadu Kesejahteraan Sosial (DTKS).',
                'prioritas' => 2,
                'bobot' => 0.0641667,
            ],
            // Subkriteria untuk Tingkatan Desil (kriteria_id: 3)
            [
                'kriteria_id' => 3,
                'nama' => 'Desil 1',
                'deskripsi' => 'Tingkat kesejahteraan terendah',
                'prioritas' => 1,
                'bobot' => 0.0715445,
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Desil 2',
                'deskripsi' => 'Tingkat kesejahteraan sangat rendah',
                'prioritas' => 2,
                'bobot' => 0.0402111,
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Desil 3',
                'deskripsi' => 'Tingkat kesejahteraan rendah',
                'prioritas' => 3,
                'bobot' => 0.0245444,
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Desil 4',
                'deskripsi' => 'Tingkat kesejahteraan menengah bawah',
                'prioritas' => 4,
                'bobot' => 0.0141000,
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Desil 5',
                'deskripsi' => 'Tingkat kesejahteraan menengah',
                'prioritas' => 5,
                'bobot' => 0.0062667,
            ],

            // Subkriteria untuk Kondisi Ekonomi (kriteria_id: 4)
            [
                'kriteria_id' => 4,
                'nama' => 'Sangat Kurang Mampu',
                'deskripsi' => 'Memiliki lebih dari 2 bantuan pemerintah',
                'prioritas' => 1,
                'bobot' => 0.0468750,
            ],
            [
                'kriteria_id' => 4,
                'nama' => 'Kurang Mampu',
                'deskripsi' => 'Memiliki 2 bantuan pemerintah',
                'prioritas' => 2,
                'bobot' => 0.0243750,
            ],
            [
                'kriteria_id' => 4,
                'nama' => 'Cukup Mampu',
                'deskripsi' => 'Mahasiswa memiliki 1 bantuan pemerintah',
                'prioritas' => 3,
                'bobot' => 0.0131250,
            ],
            [
                'kriteria_id' => 4,
                'nama' => 'Tidak Menerima Bantuan',
                'deskripsi' => 'Mahasiswa tidak memiliki bantuan pemerintah',
                'prioritas' => 4,
                'bobot' => 0.0056250,
            ],

            // Subkriteria untuk Status Orang Tua (kriteria_id: 5)
            [
                'kriteria_id' => 5,
                'nama' => 'Kedua Orang Tua Wafat',
                'deskripsi' => 'Ayah dan Ibu wafat',
                'prioritas' => 1,
                'bobot' => 0.0244444,
            ],
            [
                'kriteria_id' => 5,
                'nama' => 'Salah Satu Orang Tua Wafat',
                'deskripsi' => 'Ayah atau Ibu-nya wafat',
                'prioritas' => 2,
                'bobot' => 0.0111111,
            ],
            [
                'kriteria_id' => 5,
                'nama' => 'Kedua Orang Tua Masih Hidup',
                'deskripsi' => 'Ayah dan Ibu-nya masih hidup',
                'prioritas' => 3,
                'bobot' => 0.0044444,
            ],
        ];

        foreach ($subkriterias as $subkriteria) {
            SubKriteria::create($subkriteria);
        }
    }
}
