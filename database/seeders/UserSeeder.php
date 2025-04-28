<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Buat pengguna biasa
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Pengguna',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );
    }
}
