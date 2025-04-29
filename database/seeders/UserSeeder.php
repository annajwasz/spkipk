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
        // Hapus data yang sudah ada jika ingin fresh data
        User::truncate();

        // Cek apakah email sudah ada
        if (!User::where('email', 'najwa@admin.com')->exists()) {
            $user = User::create([
                'name' => 'Najwa',
                'email' => 'najwa@admin.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now()
            ]);

            // Berikan role super_admin
            $user->assignRole('super_admin');
        }

        // Tambahkan user lain jika diperlukan
    }
}
