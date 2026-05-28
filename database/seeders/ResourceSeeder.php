<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama terlebih dahulu agar tidak dobel saat di-run ulang
        DB::table('resources')->truncate();

        DB::table('resources')->insert([
            [
                'name' => 'Superior Double',
                'type' => 'Double Bed',
                'capacity' => 2,
                'size' => '28.0 m²',
                'price_per_hour' => 445000, // Di blade kamu menggunakan price_per_hour
                'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?q=80&w=600&auto=format&fit=crop',
                'description' => 'Kamar superior dengan kasur double yang nyaman, dilengkapi pancuran air hangat, AC, kulkas mini, dan koneksi Wi-Fi berkecepatan tinggi. Cocok untuk transit maupun istirahat jangka pendek.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Deluxe Twin',
                'type' => 'Twin Bed',
                'capacity' => 2,
                'size' => '32.0 m²',
                'price_per_hour' => 550000,
                'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=600&auto=format&fit=crop',
                'description' => 'Kamar Deluxe dengan dua kasur single terpisah. Menyuguhkan ruang yang lebih luas dengan penataan interior modern yang mewah serta fasilitas amenities kamar mandi yang lengkap.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Executive Suite',
                'type' => 'King Bed',
                'capacity' => 2,
                'size' => '45.0 m²',
                'price_per_hour' => 950000,
                'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=600&auto=format&fit=crop',
                'description' => 'Nikmati kemewahan berkelas di Executive Suite Roomly. Dilengkapi dengan bathtub bathtub premium, Smart TV berukuran besar, ruang santai terpisah, dan pemandangan jendela kota yang memukau.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}