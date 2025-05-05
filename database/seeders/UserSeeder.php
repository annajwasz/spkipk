<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Super Admin
        $superAdmin = User::create([
            'name' => 'Admin',
            'email' => 'pengelola@admin.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now()
        ]);
        $superAdmin->assignRole('super_admin');

        // Buat Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now()
        ]);
        $admin->assignRole('admin');

        // Buat beberapa mahasiswa
        $mahasiswas = [
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@user.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now()
            ],
         
        ];

        foreach ($mahasiswas as $mahasiswa) {
            $user = User::create($mahasiswa);
            $user->assignRole('mahasiswa');
        }
    }
}
