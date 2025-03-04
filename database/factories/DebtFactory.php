<?php

namespace Database\Factories;

use App\Models\Debt;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class DebtFactory extends Factory
{
    protected $model = Debt::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id ?? Customer::factory(),
            'supplier_id' => Supplier::inRandomOrder()->first()->id ?? Supplier::factory(),
            'amount' => $this->faker->randomFloat(2, 20, 1000),
            'status' => $this->faker->randomElement(['unpaid', 'paid']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
