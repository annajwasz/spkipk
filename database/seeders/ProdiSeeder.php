<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        $prodis = [
            // Produksi Pertanian
            [
                'jurusan_id' => 1,
                'nama' => 'Produksi Tanaman Hortikultura',
                'akreditasi' => 'A'
            ],
            [
                'jurusan_id' => 1,
                'nama' => 'Produksi Tanaman Perkebunan',
                'akreditasi' => 'A'
            ],
            [
                'jurusan_id' => 1,
                'nama' => 'Teknik Produksi Benih',
                'akreditasi' => 'B'
            ],
            [
                'jurusan_id' => 1,
                'nama' => 'Teknologi Produksi Tanaman Pangan',
                'akreditasi' => 'B'
            ],
            [
                'jurusan_id' => 1,
                'nama' => 'Budidaya Tanaman Perkebunan',
                'akreditasi' => 'B'
            ],
            [
                'jurusan_id' => 1,
                'nama' => 'Pengelolaan Perkebunan Kopi',
                'akreditasi' => 'C'
            ],

            
            // Teknologi Pertanian
            [
                'jurusan_id' => 2,
                'nama' => 'Keteknikan Pertanian',
                'akreditasi' => 'A'
            ],
            [
                'jurusan_id' => 2,
                'nama' => 'Teknologi Industri Pangan',
                'akreditasi' => 'A'
            ],
            [
                'jurusan_id' => 2,
                'nama' => 'Teknologi Rekayasa Pangan',
                'akreditasi' => 'C'
            ],
            
            // Peternakan
            [
                'jurusan_id' => 3,
                'nama' => 'Produksi Ternak',
                'akreditasi' => 'A'
            ],
            [
                'jurusan_id' => 3,
                'nama' => 'Manajemen Bisnis Unggas',
                'akreditasi' => 'B'
            ],
            [
                'jurusan_id' => 3,
                'nama' => 'Teknologi Pakan Ternak',
                'akreditasi' => 'C'
            ],
            
            // Manajemen Agribisnis
            [
                'jurusan_id' => 4,
                'nama' => 'Manajemen Agribisnis',
                'akreditasi' => 'A'
            ],
            [
                'jurusan_id' => 4,
                'nama' => 'Manajemen Agroindustri',
                'akreditasi' => 'A'
            ],
            // Teknologi Informasi
            [
                'jurusan_id' => 5,
                'nama' => 'Manajemen Informatika',
                'akreditasi' => 'A'
            ],
            [
                'jurusan_id' => 5,
                'nama' => 'Teknik Komputer',
                'akreditasi' => 'A'
            ],
            [
                'jurusan_id' => 5,
                'nama' => 'Teknik Informatika',
                'akreditasi' => 'A'
            ],
            [
                'jurusan_id' => 5,
                'nama' => 'Bisnis Digital',
                'akreditasi' => 'C'
            ],
            // Bahasa, Komunikasi dan Pariwisata
            [
                'jurusan_id' => 6,
                'nama' => 'Bahasa Inggris',
                'akreditasi' => 'B'
            ],
            [
                'jurusan_id' => 6,
                'nama' => 'Destinasi Pariwisata',
                'akreditasi' => 'C'
            ],
            // Kesehatan
            [
                'jurusan_id' => 7,
                'nama' => 'Manajemen Informasi Kesehatan',
                'akreditasi' => 'A'
            ],
            [
                'jurusan_id' => 7,
                'nama' => 'Gizi Klinik',
                'akreditasi' => 'B'
            ],
            [
                'jurusan_id' => 7,
                'nama' => 'Promosi Kesehatan',
                'akreditasi' => 'C'
            ],
            //Teknik
            [
                'jurusan_id' => 8,
                'nama' => 'Teknik Energi Terbarukan',
                'akreditasi' => 'A'
            ],
            [
                'jurusan_id' => 8,
                'nama' => 'Mesin Otomotif',
                'akreditasi' => 'B'
            ],
            [
                'jurusan_id' => 8,
                'nama' => 'Teknologi Rekayasa Mekatronika',
                'akreditasi' => 'C'
            ],
            //Bisnis
            [
                'jurusan_id' => 9,
                'nama' => 'Akuntansi Sektor Publik',
                'akreditasi' => 'C'
            ],
            [
                'jurusan_id' => 9,
                'nama' => 'Manajemen Pemasaran Internasional',
                'akreditasi' => 'C'
            ],
            
            
        ];

        foreach ($prodis as $prodi) {
            Prodi::create($prodi);
        }
    }
} 