<?php

namespace Database\Factories;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StaffRequest>
 */
class StaffRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'user_id' => User::factory(),
            'number' => fake()->unique()->regexify('[A-Z]{5}[0-4]{3}'),
            'title' => fake()->sentence(),
            'date' => fake()->date('Y-m-d'),
            'position_id' => Position::factory(),
            'qty' => fake()->randomDigitNotNull(),
            'note' => fake()->paragraph(),
        ];
    }
}
