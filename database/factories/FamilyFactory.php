<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Family>
 */
class FamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider_name' => fake()->name(),
            'provider_phone' => fake()->phoneNumber(),
            'members_count' => rand(1, 14),
            'youngers_count' => rand(0, 5),
            'provider_social_status' => rand(1, 6),
            'status' => rand(1, 3),
            'type' => rand(1, 6),
            'address' => fake()->address(),
            'income' => rand(0, 750),
            'housing_type' => rand(1, 4),
            'rent_cost' => rand(200, 800),
            'shares_count' => rand(1, 5),
            'income_type' => rand(1, 4),
            'other_orgs' => fake()->text(),
            'notes' => fake()->text(),
            'city_id' => rand(1, 30),
        ];
    }
}
