<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat atau Memperbarui User Utama (Admin)
        // Ini tidak akan error meskipun dijalankan berkali-kali
        User::firstOrCreate(
            ['email' => 'test@example.com'], // Kunci unik untuk pengecekan
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'gender' => 'Laki-laki',
                'birthdate' => '2000-01-01',
                'city' => 'Banyumas',
                'phone' => '08123456789',
            ]
        );

        // 2. Membuat 10 user tambahan secara acak
        User::factory(10)->create();

        // 3. Generate 15 Resource acak tambahan menggunakan Factory (Lengkap dengan gambarnya)
        \App\Models\Resource::factory(15)->create();
    }
}
