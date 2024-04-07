<?php

namespace Database\Factories;

use App\Enums\Origin;
use App\Enums\Status;
use Carbon\Carbon;
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
        $date = Carbon::now();
        $date->addDays(random_int(1, 30));
        return [
            'entry_date' => $date,
            'exit_date' => $date->copy()->addDays(1),
            'status' => Status::getRandomValue(),
            'origin' => Origin::getRandomValue(),
            'comments' => $this->faker->sentence(),
            // 'room_id' => $this->faker->numberBetween(1, 20),
            'total' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
