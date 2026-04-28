<?php

namespace Database\Factories;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    protected $model = Resource::class;

    public function definition(): array
    {
        $types = ['Room', 'Meeting', 'Hall', 'Studio', 'Workspace'];
        $type = $this->faker->randomElement($types);

        return [
            'name' => $this->faker->company() . ' ' . $type,
            'type' => $type,
            'description' => $this->faker->paragraph(),
            // Menggunakan service placeholder image gratis seperti picsum untuk dummynya
            'image' => 'https://picsum.photos/seed/' . $this->faker->uuid() . '/640/480',
            'capacity' => $this->faker->numberBetween(2, 50),
            'price_per_hour' => $this->faker->randomElement([50000, 75000, 100000, 150000, 200000, 500000]),
            'is_active' => true,
        ];
    }
}
