<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Customer::class;

    public function definition(): array
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        $privilege = $this->faker->randomElement(['none','senior', 'student','pwd']);
        return [
            'first_name' => $this->faker->firstName($gender),
            'last_name' => $this->faker->lastName(),
            'gender' => $gender,
            'email' => fake()->unique()->safeEmail(),
            'birth_date'=>$this->faker->dateTime(),
            'mobile_no'=>$this->faker->phoneNumber(),
            'address'=>$this->faker->address(),
            'points'=>$this->faker->randomFloat(2,1000,99),
            'privilege'=>$privilege,
            'image'=>$this->faker->regexify('[A-Z]{5}[0-4]{3}'),
        ];
    }
}
