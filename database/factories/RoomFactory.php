<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    public function definition(): array
    {
        $types = ['standard', 'deluxe', 'suite'];

        return [
            'name'            => ucfirst(fake()->word()) . ' ' . fake()->numberBetween(100, 999),
            'type'            => fake()->randomElement($types),
            'capacity'        => fake()->numberBetween(1, 4),
            'price_per_night' => fake()->randomFloat(2, 200000, 1500000),
            'description'     => fake()->sentence(12),
            'status'          => 'available',
            'image_path'      => null,
        ];
    }
}
