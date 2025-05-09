<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // Ambil user dengan role mahasiswa
        // $users = User::role('mahasiswa')->get();

        // // Ambil jurusan dan prodi
        // $jurusanTI = Jurusan::where('nama', 'Teknologi Informasi')->first();
        // $prodiInformatika = Prodi::where('nama', 'Teknik Informatika')->first();

        // $mahasiswas = [
        //     [
        //         'noreg_kipk' => 'KIP001',
        //         'nama' => 'Ahmad Fauzi',
        //         'NIM' => '2021573010001',
        //         'jurusan_id' => $jurusanTI->id,
        //         'prodi_id' => $prodiInformatika->id,
        //         'akreditasi' => $prodiInformatika->akreditasi,
        //         'angkatan' => '2021',
        //         'jalur_masuk' => 'SNMPTN',
        //         'ponsel' => '081234567890',
        //         'alamat' => 'Jl. Pendidikan No. 1',
        //     ],
        //     [
        //         'noreg_kipk' => 'KIP002',
        //         'nama' => 'Siti Nurhaliza',
        //         'NIM' => '2021573010002',
        //         'jurusan_id' => $jurusanTI->id,
        //         'prodi_id' => $prodiInformatika->id,
        //         'akreditasi' => $prodiInformatika->akreditasi,
        //         'angkatan' => '2021',
        //         'jalur_masuk' => 'SBMPTN',
        //         'ponsel' => '081234567891',
        //         'alamat' => 'Jl. Pendidikan No. 2',
        //     ],
        //     [
        //         'noreg_kipk' => 'KIP003',
        //         'nama' => 'Budi Santoso',
        //         'NIM' => '2021573010003',
        //         'jurusan_id' => $jurusanTI->id,
        //         'prodi_id' => $prodiInformatika->id,
        //         'akreditasi' => $prodiInformatika->akreditasi,
        //         'angkatan' => '2021',
        //         'jalur_masuk' => 'SNMPTN',
        //         'ponsel' => '081234567892',
        //         'alamat' => 'Jl. Pendidikan No. 3',
        //     ],
        // ];

        // foreach ($users as $index => $user) {
        //     if (isset($mahasiswas[$index])) {
        //         Mahasiswa::create(array_merge($mahasiswas[$index], [
        //             'user_id' => $user->id
        //         ]));
        //     }
        // }
    }
}
