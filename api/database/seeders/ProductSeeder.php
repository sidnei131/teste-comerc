<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Criar 20 produtos fictícios
        foreach (range(1, 20) as $index) {
            DB::table('products')->insert([
                'name' => $faker->word,
                'price' => $faker->numberBetween(100, 10000), // preço em centavos
                'photo' => $faker->imageUrl(640, 480, 'food', true, 'product'),
                'type' => $faker->randomElement(['food', 'drink', 'dessert']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
