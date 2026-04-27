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

        // 3. Menambahkan Resource (Room/Aset)
        \App\Models\Resource::firstOrCreate(
            ['name' => 'Deluxe Room 101'],
            [
                'type' => 'Room',
                'description' => 'A luxury deluxe room with king bed.',
                'capacity' => 2,
                'price_per_hour' => 50000,
                'is_active' => true,
            ]
        );

        \App\Models\Resource::firstOrCreate(
            ['name' => 'Meeting Room A'],
            [
                'type' => 'Meeting',
                'description' => 'Spacious meeting room for 10 people.',
                'capacity' => 10,
                'price_per_hour' => 150000,
                'is_active' => true,
            ]
        );
    }
}