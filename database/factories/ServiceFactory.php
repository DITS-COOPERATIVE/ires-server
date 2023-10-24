<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->word(),
            'type'=>$this->faker->word(),
            'description'=>$this->faker->word(),
            'fee'=>$this->faker->randomNumber(4, true),
            'points'=>$this->faker->randomFloat(2,1000,99),
        ];
    }
}
