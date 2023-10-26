<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'num_serie'=> fake()->unique()->bothify('???-###'),
            'color'=> fake()->colorName(),
            'brand'=> fake()->randomElement(["Toyota","Honda","Nissan","Ford","Volkswagen"]),
            'type'=>fake()->randomElement(["publico", "particular"]),
        ];
    }
}
