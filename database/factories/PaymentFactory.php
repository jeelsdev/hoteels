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
            //'reservation_id' => $this->faker->numberBetween(1, 20),
            // 'total_reservation' => $this->faker->numberBetween(51, 100),
            'advance_reservation' => $this->faker->numberBetween(10, 20),
            'total_xtras' => $this->faker->numberBetween(51, 100),
            'advance_xtras' => $this->faker->numberBetween(10, 20),
            'total_tours' => $this->faker->numberBetween(51, 100),
            'advance_tours' => $this->faker->numberBetween(10, 30),
        ];
    }
}
