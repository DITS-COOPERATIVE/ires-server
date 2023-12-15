<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;
    public function definition(): array
    {
        $category = $this->faker->randomElement(['Software','Hardware','Services']);
        $barcode = uniqid();
        return [
            
            'name'=>$this->faker->word(),
            'category'=>$category,
            'barcode' => $barcode,
            'model'=>$this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'price'=>$this->faker->randomNumber(4, true),
            'quantity'=>$this->faker->randomNumber(2, true),
            'points'=>$this->faker->randomFloat(2,1000,99),

        ];
    }
}
