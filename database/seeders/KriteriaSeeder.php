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
                'bobot' => 0.4566667,
            ],
            [
                'nama' => 'Terdata DTKS',
                'prioritas' => 2,
                'bobot' => 0.2566667,
            ],
            [
                'nama' => 'Tingkatan Desil',
                'prioritas' => 3,
                'bobot' => 0.1566667,
            ],
            [
                'nama' => 'Kondisi Ekonomi',
                'prioritas' => 4,
                'bobot' => 0.09,
            ],
            [
                'nama' => 'Status Orang Tua',
                'prioritas' => 5,
                'bobot' => 0.04,
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
