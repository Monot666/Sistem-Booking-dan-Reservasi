<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat Akun untuk Masing-masing Role
        $roles = ['admin', 'user', 'content_creator', 'finance'];
        
        foreach ($roles as $role) {
            $emailPrefix = str_replace(' ', '', $role);
            User::firstOrCreate(
                ['email' => $emailPrefix . '@example.com'], 
                [
                    'name' => ucwords($role) . ' User',
                    'password' => Hash::make('password'),
                    'role' => $role,
                ]
            );
        }

        // 2. Membuat 10 user tambahan secara acak
        User::factory(10)->create();

        // 3. Mengisi Tipe Kamar Spesifik (Kolom 'size' sudah dihapus agar klop dengan database)
        DB::table('resources')->insert([
            [
                'name' => 'Superior Double',
                'type' => 'Double Bed',
                'capacity' => 2,
                'price_per_hour' => 445000, 
                'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?q=80&w=600&auto=format&fit=crop',
                'description' => 'Kamar superior dengan kasur double yang nyaman, dilengkapi pancuran air hangat, AC, kulkas mini, dan koneksi Wi-Fi berkecepatan tinggi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Deluxe Twin',
                'type' => 'Twin Bed',
                'capacity' => 2,
                'price_per_hour' => 550000,
                'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=600&auto=format&fit=crop',
                'description' => 'Kamar Deluxe dengan dua kasur single terpisah. Menyuguhkan ruang yang lebih luas dengan penataan interior modern yang mewah.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Executive Suite',
                'type' => 'King Bed',
                'capacity' => 2,
                'price_per_hour' => 950000,
                'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=600&auto=format&fit=crop',
                'description' => 'Nikmati kemewahan berkelas di Executive Suite Roomly. Dilengkapi dengan bathtub premium, Smart TV, dan ruang santai terpisah.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        
        // 4. Dummy Transactions
        \App\Models\Transaction::insert([
            ['date' => '2026-03-12', 'description' => 'Room Booking - BK001', 'type' => 'Revenue', 'amount' => 535000, 'method' => 'Virtual Account', 'status' => 'Completed', 'created_at' => now(), 'updated_at' => now()],
            ['date' => '2026-03-12', 'description' => 'Staff Salaries - Praya', 'type' => 'Expense', 'amount' => 5000000, 'method' => 'Bank Transfer', 'status' => 'Completed', 'created_at' => now(), 'updated_at' => now()],
            ['date' => '2026-03-12', 'description' => 'Room Booking - BK002', 'type' => 'Revenue', 'amount' => 535000, 'method' => 'Paypal', 'status' => 'Completed', 'created_at' => now(), 'updated_at' => now()],
            ['date' => '2026-03-12', 'description' => 'Maintenance Supplies', 'type' => 'Expense', 'amount' => 1000000, 'method' => 'Virtual Account', 'status' => 'Completed', 'created_at' => now(), 'updated_at' => now()],
            ['date' => '2026-03-12', 'description' => 'Room Booking - BK003', 'type' => 'Revenue', 'amount' => 535000, 'method' => 'Virtual Account', 'status' => 'Completed', 'created_at' => now(), 'updated_at' => now()],
            ['date' => '2026-03-12', 'description' => 'Booking Cancellation', 'type' => 'Refund', 'amount' => 535000, 'method' => 'Credit Card', 'status' => 'Completed', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 5. Dummy Banners
        \App\Models\Banner::insert([
            ['layout_name' => 'Dashboard', 'position' => 'Foto 1', 'image_path' => null, 'external_link' => 'https://promo1.com', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['layout_name' => 'Dashboard Explore', 'position' => 'Foto 2', 'image_path' => null, 'external_link' => 'https://promo2.com', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
        
    }
}