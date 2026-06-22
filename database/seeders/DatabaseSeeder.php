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

        // 3. Mengisi Tipe Kamar Fisik (4 Tingkatan)
        $allFacilities = ['🚿 Shower', '❄️ AC', '📶 WiFi', '📺 Smart TV', '🔲 Mini Fridge', '☕ Coffee Maker', '🔒 Safe Deposit Box', '💨 Hairdryer', '🛁 Bathtub'];
        
        $roomTypes = [
            [
                'name' => 'Presidential Suite', // Tingkat 4
                'type' => 'King Bed',
                'capacity' => 4,
                'price_per_hour' => 2500000, 
                'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=600&auto=format&fit=crop',
                'description' => 'Kamar termewah di tingkat tertinggi dengan pemandangan kota 360 derajat. Dilengkapi fasilitas VVIP.',
                'size' => '80.0 m²',
                'facilities' => implode(', ', $allFacilities),
                'max_adults' => 4,
                'max_children' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Executive Suite', // Tingkat 3
                'type' => 'King Bed',
                'capacity' => 2,
                'price_per_hour' => 1200000,
                'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?q=80&w=600&auto=format&fit=crop',
                'description' => 'Kamar premium yang luas dan nyaman, cocok untuk tamu VIP maupun keluarga.',
                'size' => '45.0 m²',
                'facilities' => implode(', ', fake()->randomElements($allFacilities, 7)),
                'max_adults' => 2,
                'max_children' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Deluxe Room', // Tingkat 2
                'type' => 'Queen Bed',
                'capacity' => 2,
                'price_per_hour' => 750000,
                'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=600&auto=format&fit=crop',
                'description' => 'Kamar modern dengan fasilitas yang memanjakan Anda selama menginap.',
                'size' => '32.0 m²',
                'facilities' => implode(', ', fake()->randomElements($allFacilities, 5)),
                'max_adults' => 2,
                'max_children' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Standard King', // Tingkat 1
                'type' => 'King Bed',
                'capacity' => 2,
                'price_per_hour' => 450000,
                'image' => 'https://images.unsplash.com/photo-1590490359683-658d3d23f972?q=80&w=600&auto=format&fit=crop',
                'description' => 'Kamar standar dengan satu ranjang King yang sangat nyaman untuk istirahat optimal.',
                'size' => '24.0 m²',
                'facilities' => implode(', ', fake()->randomElements($allFacilities, 4)),
                'max_adults' => 2,
                'max_children' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Standard Twin', // Tingkat 1
                'type' => 'Twin Bed',
                'capacity' => 2,
                'price_per_hour' => 450000,
                'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=600&auto=format&fit=crop',
                'description' => 'Kamar standar dengan dua ranjang terpisah, pilihan tepat untuk perjalanan bersama teman.',
                'size' => '24.0 m²',
                'facilities' => implode(', ', fake()->randomElements($allFacilities, 4)),
                'max_adults' => 2,
                'max_children' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        
        DB::table('resources')->insert($roomTypes);

        // 3.1. Mengisi Data Nomor Kamar (Room Units)
        $roomUnits = [];
        
        // Tingkat 4: Kamar 1 - 5 (Presidential Suite, ID: 1)
        for ($i = 1; $i <= 5; $i++) {
            $roomUnits[] = ['resource_id' => 1, 'room_number' => (string)$i, 'created_at' => now(), 'updated_at' => now()];
        }
        
        // Tingkat 3: Kamar 6 - 30 (Executive Suite, ID: 2)
        for ($i = 6; $i <= 30; $i++) {
            $roomUnits[] = ['resource_id' => 2, 'room_number' => (string)$i, 'created_at' => now(), 'updated_at' => now()];
        }
        
        // Tingkat 2: Kamar 31 - 80 (Deluxe Room, ID: 3)
        for ($i = 31; $i <= 80; $i++) {
            $roomUnits[] = ['resource_id' => 3, 'room_number' => (string)$i, 'created_at' => now(), 'updated_at' => now()];
        }
        
        // Tingkat 1: Kamar 81 - 130 (Standard King, ID: 4)
        for ($i = 81; $i <= 130; $i++) {
            $roomUnits[] = ['resource_id' => 4, 'room_number' => (string)$i, 'created_at' => now(), 'updated_at' => now()];
        }
        
        // Tingkat 1: Kamar 131 - 180 (Standard Twin, ID: 5)
        for ($i = 131; $i <= 180; $i++) {
            $roomUnits[] = ['resource_id' => 5, 'room_number' => (string)$i, 'created_at' => now(), 'updated_at' => now()];
        }
        
        DB::table('room_units')->insert($roomUnits);
        
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