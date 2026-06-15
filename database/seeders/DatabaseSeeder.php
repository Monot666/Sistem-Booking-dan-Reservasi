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

        // 3. Mengisi Tipe Kamar Spesifik beserta detail tambahannya
        $allFacilities = ['🚿 Shower', '❄️ AC', '📶 WiFi', '📺 Smart TV', '🔲 Mini Fridge', '☕ Coffee Maker', '🔒 Safe Deposit Box', '💨 Hairdryer', '🛁 Bathtub'];
        
        DB::table('resources')->insert([
            [
                'name' => 'Superior Double',
                'type' => 'Double Bed',
                'capacity' => 2,
                'price_per_hour' => 445000, 
                'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?q=80&w=600&auto=format&fit=crop',
                'description' => 'Kamar superior dengan kasur double yang nyaman, dilengkapi pancuran air hangat, AC, kulkas mini, dan koneksi Wi-Fi berkecepatan tinggi.',
                'size' => '28.0 m²',
                'facilities' => implode(', ', fake()->randomElements($allFacilities, rand(3, 5))),
                'max_adults' => 2,
                'max_children' => 1,
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
                'size' => '32.0 m²',
                'facilities' => implode(', ', fake()->randomElements($allFacilities, rand(4, 6))),
                'max_adults' => 2,
                'max_children' => 2,
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
                'size' => '45.0 m²',
                'facilities' => implode(', ', fake()->randomElements($allFacilities, rand(5, 8))),
                'max_adults' => 2,
                'max_children' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        
        // 3.1. Membuat 97 tipe kamar tambahan secara acak agar total menjadi 100 data
        \App\Models\Room::factory(97)->create();
        
        // 4. Dummy Transactions
        // Pindah ke bawah setelah Bookings terbuat agar bisa di-relasikan

        // 5. Dummy Banners
        $layouts = [
            ['layout_name' => 'Dashboard', 'positions' => ['Foto 1']],
            ['layout_name' => 'Dashboard Explore', 'positions' => ['Foto 1', 'Foto 2', 'Foto 3', 'Foto 4']],
            ['layout_name' => 'Order', 'positions' => ['Foto 1']],
            ['layout_name' => 'Pembayaran', 'positions' => ['Foto 1', 'Foto 2']],
            ['layout_name' => 'Konfirmasi Pembayaran', 'positions' => ['Foto 1']],
        ];

        $bannerInserts = [];
        foreach ($layouts as $layout) {
            foreach ($layout['positions'] as $pos) {
                $bannerInserts[] = [
                    'layout_name' => $layout['layout_name'],
                    'position'    => $pos,
                    'image_path'  => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1200&h=250&q=80',
                    'external_link'=> 'https://example.com/promo-' . strtolower(str_replace(' ', '-', $layout['layout_name'])) . '-' . str_replace(' ', '', strtolower($pos)),
                    'is_active'   => true,
                    'created_at'  => now(),
                    'updated_at'  => now()
                ];
            }
        }
        \App\Models\Banner::insert($bannerInserts);
        
        // 6. Dummy Bookings terintegrasi dengan users
        $allUsers = User::where('role', 'user')->get();
        $rooms = \App\Models\Room::all();
        $statuses = \App\Enums\BookingStatus::cases();

        foreach ($allUsers as $user) {
            $bookingCount = rand(1, 3);
            for ($i = 0; $i < $bookingCount; $i++) {
                $room = $rooms->random();
                $startTime = now()->subDays(rand(1, 30))->addHours(rand(1, 10));
                $days = rand(1, 3);
                $endTime = (clone $startTime)->addDays($days);
                $totalPrice = $room->price_per_hour * $days;

                \App\Models\Booking::create([
                    'no_pesanan' => 'BK' . rand(10000, 99999),
                    'user_id' => $user->id,
                    'resource_id' => $room->id,
                    'nama_pemesan' => $user->name,
                    'no_hp' => '0812' . rand(10000000, 99999999),
                    'email' => $user->email,
                    'nama_pengunjung' => $user->name,
                    'permintaan_khusus' => 'Kamar bebas asap rokok',
                    'room_name' => $room->name,
                    'room_price' => $room->price_per_hour,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'guest_count' => rand(1, $room->capacity),
                    'total_price' => $totalPrice,
                    'tax_and_fee' => $totalPrice * 0.1,
                    'status' => $statuses[array_rand($statuses)]->value,
                ]);
            }
        }

        // 7. Dummy Transactions (Generates 80 random transactions spanning 6 months via Factory)
        // Dipanggil di sini karena butuh relasi ke Booking (booking_id)
        \App\Models\Transaction::factory(80)->create();
    }
}