<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_product()
    {
        $payload = [
            'name' => 'Example Product',
            'price' => 1500, // preço em centavos
            'photo' => 'https://via.placeholder.com/640x480.png',
            'type' => 'food',
        ];
        $response = $this->postJson('/api/products', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', ['name' => 'Example Product']);
    }

    public function test_can_show_product()
    {
        $product = Product::factory()->create();
        $response = $this->getJson("/api/products/{$product->id}");
        
        $response
            ->assertStatus(200)
            ->assertJsonPath('id', $product->id)
            ->assertJsonStructure([
                'id',
                'name',
                'price',
                'type',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create();
        $payload = [
            'name' => 'Updated Product',
            'price' => 2000,// centavos
            'photo' => 'https://via.placeholder.com/640x480.png',
            'type' => 'drink',
        ];

        $response = $this->putJson("/api/products/{$product->id}", $payload);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated Product']);
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();
        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    public function test_validates_required_fields_when_creating_product()
    {
        $response = $this->postJson('/api/products', []);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'price', 'type']);
    }

    public function test_fails_to_create_product_with_invalid_price()
    {
        $payload = [
            'name' => 'Invalid price',
            'price' => -1000,
            'type' => 'food',
        ];
        $response = $this->postJson('/api/products', $payload);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['price']);
    }
}
