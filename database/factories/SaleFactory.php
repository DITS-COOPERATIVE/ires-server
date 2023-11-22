<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id'=>$this->faker->randomNumber(1, true),
            'total_price'=>$this->faker->randomNumber(4, true),
            'total_points'=>$this->faker->randomFloat(2,1000,99),
        ];
    }
}
