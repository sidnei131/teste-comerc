<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->numberBetween(100, 10000), // preço em centavos
            'photo' => $this->faker->imageUrl(640, 480, 'food', true, 'product'),
            'type' => $this->faker->randomElement(['food', 'drink', 'dessert']),
        ];
    }
}
