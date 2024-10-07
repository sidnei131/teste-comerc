<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'birth_date' => $this->faker->date,
            'address' => $this->faker->address,
            'address_extra' => $this->faker->secondaryAddress,
            'neighborhood' => $this->faker->city,
            'zip_code' => $this->faker->postcode,
        ];
    }
}
