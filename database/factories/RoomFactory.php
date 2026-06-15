<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        $modifiers = ['Standard', 'Deluxe', 'Superior', 'Premium', 'Executive', 'Grand', 'Royal', 'Presidential', 'Family', 'Ocean View', 'City View', 'Boutique'];
        $bedTypes = ['Single', 'Double', 'Twin', 'King', 'Queen', 'Suite', 'Villa', 'Studio'];
        
        $modifier = $this->faker->randomElement($modifiers);
        $bedType = $this->faker->randomElement($bedTypes);
        $roomName = $modifier . ' ' . $bedType;

        $allFacilities = ['🚿 Shower', '❄️ AC', '📶 WiFi', '📺 Smart TV', '🔲 Mini Fridge', '☕ Coffee Maker', '🔒 Safe Deposit Box', '💨 Hairdryer', '🛁 Bathtub'];

        return [
            'name' => $roomName,
            'type' => $bedType . ' Bed',
            'description' => 'Nikmati pengalaman menginap terbaik di kamar ' . $roomName . ' kami. ' . $this->faker->paragraph(),
            // Menggunakan service placeholder image gratis seperti picsum untuk dummynya
            'image' => 'https://picsum.photos/seed/' . $this->faker->uuid() . '/640/480',
            'capacity' => $this->faker->numberBetween(2, 50),
            'price_per_hour' => $this->faker->randomElement([50000, 75000, 100000, 150000, 200000, 500000]),
            'is_active' => true,
            'size' => $this->faker->numberBetween(20, 100) . '.0 m²',
            'facilities' => implode(', ', $this->faker->randomElements($allFacilities, $this->faker->numberBetween(3, 6))),
            'max_adults' => $this->faker->numberBetween(1, 4),
            'max_children' => $this->faker->numberBetween(0, 3),
        ];
    }
}
