<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['CASH', 'DEBIT', 'CREDIT', 'TRANSFER']),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'reservation_id' => $this->faker->numberBetween(1, 20),
        ];
    }
}
