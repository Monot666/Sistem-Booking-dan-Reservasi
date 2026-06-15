<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\TransactionType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement([TransactionType::Revenue, TransactionType::Expense, TransactionType::Refund]);
        
        if ($type === TransactionType::Revenue) {
            $desc = 'Room Booking - BK00' . fake()->randomNumber(3, true);
            $amount = fake()->numberBetween(30, 250) * 10000;
        } elseif ($type === TransactionType::Expense) {
            $desc = fake()->randomElement(['Staff Salaries', 'Maintenance Supplies', 'Electricity Bill', 'Water Bill', 'Internet & Phone', 'Marketing Ads']);
            $amount = fake()->numberBetween(50, 500) * 10000;
        } else {
            $desc = 'Booking Cancellation - BK00' . fake()->randomNumber(3, true);
            $amount = fake()->numberBetween(20, 100) * 10000;
        }

        $date = fake()->dateTimeBetween('-6 months', 'now');
        
        $bookingId = null;
        if ($type === TransactionType::Revenue || $type === TransactionType::Refund) {
            $booking = \App\Models\Booking::inRandomOrder()->first();
            $bookingId = $booking ? $booking->id : null;
        }

        return [
            'booking_id' => $bookingId,
            'date' => $date->format('Y-m-d'),
            'description' => $desc,
            'type' => $type,
            'amount' => $amount,
            'method' => fake()->randomElement(['Virtual Account', 'Bank Transfer', 'Credit Card', 'Paypal', 'Cash']),
            'status' => 'Completed',
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
