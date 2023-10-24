<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id'=>$this->faker->randomNumber(1, true),
            'product_id'=>$this->faker->randomNumber(1, true),
            'quantity'=>$this->faker->randomNumber(2, true),
            'status'=>$this->faker->randomElement(['approved','pending','cancelled']),
        ];
    }
}
