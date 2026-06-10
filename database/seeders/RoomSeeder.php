<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeds sample room data into the resources table.
 */
class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('resources')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rooms = [
            [
                'name' => 'Standard Single Room',
                'type' => 'Single Bed',
                'capacity' => 1,
                'max_adults' => 1,
                'max_children' => 0,
                'size' => '20.0 m²',
                'facilities' => '🚿 Shower,❄️ AC,📶 Free WiFi,📺 LED TV',
                'price_per_hour' => 250000,
                'image' => 'https://images.unsplash.com/photo-1505691938895-1758d7eaa511?q=80&w=600&auto=format&fit=crop',
                'description' => 'A cozy standard room designed for solo travelers. Equipped with essential amenities to ensure a comfortable stay during your transit or short trip.',
            ],
            [
                'name' => 'Superior Double Room',
                'type' => 'Double Bed',
                'capacity' => 2,
                'max_adults' => 2,
                'max_children' => 1,
                'size' => '28.0 m²',
                'facilities' => '🚿 Shower,❄️ AC,📶 Free WiFi,📺 LED TV,☕ Coffee & Tea Maker,🔒 Safe Deposit Box',
                'price_per_hour' => 450000,
                'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?q=80&w=600&auto=format&fit=crop',
                'description' => 'Superior room featuring a spacious double bed. Perfect for couples or friends looking for a balance of comfort and value.',
            ],
            [
                'name' => 'Deluxe Twin Room',
                'type' => 'Twin Bed',
                'capacity' => 2,
                'max_adults' => 2,
                'max_children' => 1,
                'size' => '32.0 m²',
                'facilities' => '🚿 Shower,❄️ AC,📶 Free WiFi,📺 LED TV,☕ Coffee & Tea Maker,🧊 Mini Fridge,💨 Hairdryer',
                'price_per_hour' => 550000,
                'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=600&auto=format&fit=crop',
                'description' => 'Deluxe room with two separate single beds. Offers more space with modern interior design and complete bathroom amenities.',
            ],
            [
                'name' => 'Family Suite',
                'type' => 'King + Sofa Bed',
                'capacity' => 4,
                'max_adults' => 2,
                'max_children' => 2,
                'size' => '50.0 m²',
                'facilities' => '🚿 Shower,🛁 Bathtub,❄️ AC,📶 Free WiFi,📺 Smart TV,☕ Coffee & Tea Maker,🍳 Kitchenette,🧊 Refrigerator',
                'price_per_hour' => 850000,
                'image' => 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=600&auto=format&fit=crop',
                'description' => 'The perfect choice for families. Featuring a small living area, a kitchenette for light cooking, and a relaxing bathtub.',
            ],
            [
                'name' => 'Presidential Villa',
                'type' => 'Grand King Bed',
                'capacity' => 5,
                'max_adults' => 3,
                'max_children' => 2,
                'size' => '120.0 m²',
                'facilities' => '🏊 Private Pool,🛁 Premium Bathtub,❄️ AC,📶 High-Speed WiFi,📺 65" Smart TV,🍳 Full Kitchen,🍷 Mini Bar,👔 Laundry Service',
                'price_per_hour' => 2500000,
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=600&auto=format&fit=crop',
                'description' => 'Ultimate luxury with a private swimming pool and 24-hour exclusive butler service. Designed for those who seek the highest level of privacy and comfort.',
            ],
            [
                'name' => 'Studio Executive',
                'type' => 'Queen Bed',
                'capacity' => 2,
                'max_adults' => 1,
                'max_children' => 1,
                'size' => '35.0 m²',
                'facilities' => '🚿 Shower,❄️ AC,📶 Free WiFi,📺 LED TV,☕ Coffee & Tea Maker,💼 Ergonomic Work Desk,🧊 Mini Fridge',
                'price_per_hour' => 600000,
                'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=600&auto=format&fit=crop',
                'description' => 'Tailored for professionals who need a comfortable workspace within their room. Combines modern business amenities with a relaxing atmosphere.',
            ]
        ];

        foreach ($rooms as $room) {
            DB::table('resources')->insert(array_merge($room, [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
