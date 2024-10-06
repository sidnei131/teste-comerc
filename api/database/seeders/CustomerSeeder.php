<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // 50 clientes fictícios
        foreach (range(1, 50) as $index) {
            DB::table('customers')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'phone' => $faker->phoneNumber,
                'birth_date' => $faker->date(),
                'address' => $faker->address,
                'address_extra' => $faker->secondaryAddress,
                'neighborhood' => $faker->city,
                'zip_code' => $faker->postcode,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
