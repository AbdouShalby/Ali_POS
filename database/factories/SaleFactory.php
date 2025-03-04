<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id ?? Customer::factory(),
            'total_amount' => $this->faker->randomFloat(2, 50, 2000),
            'sale_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
