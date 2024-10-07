<?php

namespace Tests\Unit;

use App\Models\Customer;
use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_order()
    {
        $customer = Customer::factory()->create();
        $products = Product::factory()->count(2)->create();

        $payload = [
            'customer_id' => $customer->id,
            'products' => $products->map(fn($product) => [
                'id' => $product->id,
                'quantity' => rand(1, 5),
            ])->toArray()
        ];

        $response = $this->postJson('/api/orders', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', ['customer_id' => $customer->id]);
    }

    public function test_can_list_order()
    {
        $orders = Order::factory()->count(5)->create();
        $response = $this->getJson('/api/orders');

        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    public function test_can_show_order()
    {
        $customer = Customer::factory()->create();
        $order = Order::factory()->create(['customer_id' => $customer->id]);
        $products = Product::factory()->count(2)->create();

        $order->products()->attach($products, ['quantity' => 3]);
        $response = $this->getJson("/api/orders/{$order->id}");

        $response
            ->assertStatus(200)
            ->assertJsonPath('id', $order->id)
            ->assertJsonStructure([
                'id',
                'customer_id',
                'products' => [
                    '*' => [
                        'id',
                        'name',
                        'price',
                        'pivot' => ['quantity'],
                    ],
                ],
                'customer' => ['id', 'name', 'email'],
            ]);
    }

    public function test_can_update_order()
    {
        $customer = Customer::factory()->create();
        $order = Order::factory()->create(['customer_id' => $customer->id]);
        $products = Product::factory()->count(3)->create();

        $payload = [
            'customer_id' => $customer->id,
            'products' => $products->map(fn($product) => [
                'id' => $product->id,
                'quantity' => 2,
            ])->toArray()
        ];

        $response = $this->putJson("/api/orders/{$order->id}", $payload);

        $response->assertStatus(200);
        $this->assertDatabaseHas('orders_products', [
            'order_id' => $order->id,
            'product_id' => $products->first()->id,
            'quantity' => 2
        ]);
    }

    public function test_can_delete_order()
    {
        $order = Order::factory()->create();
        $response = $this->deleteJson("/api/orders/{$order->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('orders', ['id' => $order->id]);
    }

    public function test_can_calculates_total_price_correctly()
    {
        $customer = Customer::factory()->create();
        $order = Order::factory()->create(['customer_id' => $customer->id]);
        $products = Product::factory()->count(2)->createMany([
            ['price' => 1000],
            ['price' => 2000],
        ]);

        $order->products()->attach($products[0], ['quantity' => 3]);
        $order->products()->attach($products[1], ['quantity' => 2]);

        $response = $this->getJson("/api/orders/{$order->id}");

        $expectedTotalPrice = (3 * 1000) + (2 * 2000);
        $response->assertJson(['total_price' => $expectedTotalPrice]);
    }
}
