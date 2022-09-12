<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->postcode,
            'name' => $this->faker->name,
            'quantity' => $this->faker->numberBetween(10000,60000),
            'price' => $this->faker->numberBetween(10000,60000),
            'entry_date' => $this->faker->date,
            'due_date' => $this->faker->date
        ];
    }
}
