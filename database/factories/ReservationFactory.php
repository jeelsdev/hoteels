<?php

namespace Database\Factories;

use App\Enums\Origin;
use App\Enums\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $startDate = Carbon::now()->subDays(rand(0, 365));
        $endDate = $startDate->copy()->addDays(rand(1, 4));

        return [
            'reservation_code' => Str::uuid()->toString(),
            'entry_date' => $startDate,
            'exit_date' => $endDate,
            'status' => Status::getRandomValue(),
            'origin' => Origin::getRandomValue(),
            'comments' => $this->faker->sentence(),
            'created_at' => $startDate,
            'updated_at' => $endDate,
        ];
    }
}
