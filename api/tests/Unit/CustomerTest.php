<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_customer()
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '(11) 99123-4567',
            'birth_date' => '1990-01-01',
            'address' => '123 Main St',
            'neighborhood' => 'Downtown',
            'zip_code' => '12345678',
        ];

        $response = $this->postJson('/api/customers', $payload);
        $response->assertStatus(201);
        $this->assertDatabaseHas('customers', ['email' => 'johndoe@example.com']);
    }

    public function test_can_list_customers()
    {
        Customer::factory()->count(3)->create();

        $response = $this->getJson('/api/customers');

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_show_customer()
    {
        $customer = Customer::factory()->create();
        $response = $this->getJson("/api/customers/{$customer->id}");

        $response
            ->assertStatus(200)
            ->assertJsonPath('id', $customer->id)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'phone',
                'birth_date',
                'address',
                'address_extra',
                'neighborhood',
                'zip_code',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);
    }

    public function test_can_update_customer()
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '(11) 99123-4567',
            'birth_date' => '1990-01-01',
            'address' => '123 Main St',
            'neighborhood' => 'Downtown',
            'zip_code' => '12345678',
        ];
        $customer = Customer::factory()->create($payload);
        $payload['email'] = 'janedoe@example.com';
        $response = $this->putJson("/api/customers/{$customer->id}", $payload);

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', ['email' => 'janedoe@example.com']);
    }

    public function test_can_delete_customer()
    {
        $customer = Customer::factory()->create();
        $response = $this->deleteJson("/api/customers/{$customer->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('customers', ['id' => $customer->id]);
    }

    public function test_fails_to_create_customer_with_invalid_phone()
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '(11) a9123-4567',
            'birth_date' => '1990-01-01',
            'address' => '123 Main St',
            'neighborhood' => 'Downtown',
            'zip_code' => '12345678',
        ];

        $response = $this->postJson('/api/customers', $payload);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['phone']);
    }
}
