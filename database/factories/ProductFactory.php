<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->text(200),
            'article' => fake()->numberBetween(1000000, 9000000),
            'price' => fake()->numberBetween(350, 1500),
        ];
    }
}
