<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswas = [
            [
                'noreg_kipk' => 'KIP001',
                'nama' => 'Ahmad Fauzi',
                'NIM' => '2021573010001',
                'jurusan' => 'Teknik',
                'prodi' => 'Teknik Informatika',
                'angkatan' => '2021',
                'semester' => '5',
                'jalur_masuk' => 'SNMPTN',
                'ponsel' => '081234567890',
                'alamat' => 'Jl. Pendidikan No. 1',
            ],
            [
                'noreg_kipk' => 'KIP002',
                'nama' => 'Siti Nurhaliza',
                'NIM' => '2021573010002',
                'jurusan' => 'Teknik',
                'prodi' => 'Teknik Informatika',
                'angkatan' => '2021',
                'semester' => '5',
                'jalur_masuk' => 'SBMPTN',
                'ponsel' => '081234567891',
                'alamat' => 'Jl. Pendidikan No. 2',
            ],
            [
                'noreg_kipk' => 'KIP003',
                'nama' => 'Budi Santoso',
                'NIM' => '2021573010003',
                'jurusan' => 'Teknik',
                'prodi' => 'Teknik Informatika',
                'angkatan' => '2021',
                'semester' => '5',
                'jalur_masuk' => 'SNMPTN',
                'ponsel' => '081234567892',
                'alamat' => 'Jl. Pendidikan No. 3',
            ],
        ];

        foreach ($mahasiswas as $mahasiswa) {
            Mahasiswa::create($mahasiswa);
        }
    }
}
