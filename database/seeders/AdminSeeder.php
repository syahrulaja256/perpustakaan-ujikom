<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin123@gmail.com'], // cek email dulu
            [
                'name' => 'admin',
                'password' => Hash::make('12345678'),
                'role' => 'admin'
            ]
        );

        // Petugas
        User::updateOrCreate(
            ['email' => 'petugas@gmail.com'],
            [
                'name' => 'petugas',
                'password' => Hash::make('12345678'),
                'role' => 'petugas'
            ]
        );
    }
}
