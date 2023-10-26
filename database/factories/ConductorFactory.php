<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conductor>
 */
class ConductorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'num_doc' => fake()->unique()->numerify('#######'),
            'type_doc' => fake()->randomElement(['cedula', 'extranjeria', 'otro']),
            'name' => fake()->firstName(),
            'other_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' => fake()->unique()->numerify('##########'),
            'email' => fake()->unique()->safeEmail(),
            'address' => fake()->address(),
            'city' => fake()->city(),
        ];
    }
}
