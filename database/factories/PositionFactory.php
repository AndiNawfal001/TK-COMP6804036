<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $names = [
            'Administrative Staff',
            'Customer Service Representative',
            'Digital Marketing Specialist',
            'Software Engineer',
            'UI/UX Designer',
            'Data Analyst',
            'IT Project Manager',
            'Accountant',
            'Human Resources Officer',
            'Content Creator',
            'Network Technician',
            'Legal Officer',
        ];

        return [
            'name' => fake()->unique()->randomElement($names),
        ];
    }
}
