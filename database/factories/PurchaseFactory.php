<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition()
    {
        return [
            'supplier_id' => Supplier::inRandomOrder()->first()->id ?? Supplier::factory(),
            'total_amount' => $this->faker->randomFloat(2, 100, 5000),
            'invoice_number' => strtoupper($this->faker->unique()->bothify('INV-#####')),
            'purchase_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
