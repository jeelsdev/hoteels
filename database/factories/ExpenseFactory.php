<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Carbon::now()->subDays(4);
        $endDate = Carbon::now()->addDays(4);
        $createdAt = $this->faker->dateTimeBetween($startDate, $endDate);
        return [
            'description' => $this->faker->words(1, true),
            'amount' => $this->faker->randomFloat(2,1,50),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
