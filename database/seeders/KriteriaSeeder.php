<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriterias = [
            [
                'nama' => 'Kepemilikan KIP',
                'prioritas' => 1,
                'bobot' => 0.5555,
            ],
            [
                'nama' => 'Tingkatan Desil',
                'prioritas' => 2,
                'bobot' => 0.25,
            ],
            [
                'nama' => 'Kondisi Ekonomi',
                'prioritas' => 3,
                'bobot' => 0.20,
            ],
            
        ];

        foreach ($kriterias as $kriteria) {
            Kriteria::create($kriteria);
        }
    }
}
