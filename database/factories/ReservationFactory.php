<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'entry_date' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'exit_date' => $this->faker->dateTimeBetween('+1 week', '+2 week'),
            'status_id' => $this->faker->numberBetween(1, 3),
            'origin' => $this->faker->randomElement(['WEB', 'APP', 'CALL', 'RED', 'BOOKING', 'OTHERS']),
            'room_id' => $this->faker->numberBetween(1, 20),
        ];
    }
}
