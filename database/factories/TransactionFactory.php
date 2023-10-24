<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sale_id'=>$this->faker->randomNumber(1, true),
            'amount_rendered'=>$this->faker->randomNumber(4, true),
            'change'=>$this->faker->randomNumber(2, true),
        ];
    }
}
