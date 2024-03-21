<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_type_id' => $this->faker->numberBetween(1, 4),
            'code' => $this->faker->unique()->randomNumber(4),
            'floor' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->text(100),
        ];
    }
}
