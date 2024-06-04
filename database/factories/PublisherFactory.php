<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Faker\Generator as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publisher>
 */
class PublisherFactory extends Factory
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
            'phone' => fake()->numerify('01#########'), // Generates a phone number starting with "01" and 10 to 12 digits long
            'email' => fake()->unique()->safeEmail,
            'address' => fake()->address,
            'created_by' => 1,
        ];
    }
}
