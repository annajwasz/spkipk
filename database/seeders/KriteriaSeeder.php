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
                'bobot' => 0.5208333,
            ],
            [
                'nama' => 'Tingkatan Desil',
                'prioritas' => 2,
                'bobot' => 0.2708333,
            ],
            [
                'nama' => 'Kondisi Ekonomi',
                'prioritas' => 3,
                'bobot' => 0.1458333,
            ],
            [
                'nama' => 'Status Orang Tua',
                'prioritas' => 4,
                'bobot' => 0.0625000,
            ],
        ];

        // Hitung total bobot untuk memastikan jumlahnya 1
        $totalBobot = array_sum(array_column($kriterias, 'bobot'));
        
        // Normalisasi bobot jika total tidak tepat 1
        if (abs($totalBobot - 1) > 0.0001) {
            foreach ($kriterias as &$kriteria) {
                $kriteria['bobot'] = $kriteria['bobot'] / $totalBobot;
            }
        }

        foreach ($kriterias as $kriteria) {
            Kriteria::create($kriteria);
        }
    }
}
