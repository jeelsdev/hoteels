<?php

namespace Database\Factories;

use App\Enums\Origin;
use App\Enums\Status;
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
            'status' => Status::getRandomValue(),
            'origin' => Origin::getRandomValue(),
            'comments' => $this->faker->sentence(),
            'room_id' => $this->faker->numberBetween(1, 20),
            'total' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
