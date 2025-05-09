<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $jurusans = [
            ['nama' => 'Produksi Pertanian'],
            ['nama' => 'Teknologi Pertanian'],
            ['nama' => 'Peternakan'],
            ['nama' => 'Manajemen Agribisnis'],
            ['nama' => 'Teknologi Informasi'],
            ['nama' => 'Bahasa, Komunikasi dan Pariwisata'],
            ['nama' => 'Kesehatan'],
            ['nama' => 'Teknik'],
            ['nama' => 'Bisnis'],
        ];

        foreach ($jurusans as $jurusan) {
            Jurusan::create($jurusan);
        }
    }
} 