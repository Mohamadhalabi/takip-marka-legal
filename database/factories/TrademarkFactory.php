<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trademark>
 */
class TrademarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'application_no' => $this->faker->unique()->numberBetween(1, 1000000),
            'application_date' => $this->faker->dateTimeBetween('-1 years', '-1 days'),
            'register_no' => $this->faker->unique()->numberBetween(1, 1000000),
            'register_date' => $this->faker->dateTimeBetween('-1 years', '-1 days'),
            'intreg_no' => $this->faker->unique()->numberBetween(1, 1000000),
            'name' => $this->faker->unique()->name,
            'slug' => $this->faker->unique()->slug,
            'nice_classes' => $this->faker->unique()->name,
            'vienna_classes' => $this->faker->unique()->name,
            'type' => $this->faker->unique()->name,
            'pub_type' => $this->faker->unique()->name,
            'image_path' => $this->faker->unique()->name,
        ];
    }
}
