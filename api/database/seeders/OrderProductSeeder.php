<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Product;
use App\Models\Order;

class OrderProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $orders = Order::all();
        $products = Product::all();

        foreach ($orders as $order) {
            $productCount = $faker->numberBetween(1, 5);
            $randomProducts = $products->random($productCount);

            foreach ($randomProducts as $product) {
                DB::table('orders_products')->insert([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $faker->numberBetween(1, 10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
