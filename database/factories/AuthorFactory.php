<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'date_of_birth' => fake()->date,
            'nationality' => fake()->country,
            'phone' => fake()->numerify('01#########'), // Generates a phone number starting with "01" and 10 to 12 digits long
            'email' => fake()->unique()->safeEmail,
            'address' => fake()->address,
            'created_by' => 1,
        ];
    }
}
