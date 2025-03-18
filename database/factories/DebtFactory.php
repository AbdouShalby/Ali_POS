<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Debt;
use App\Models\Product;
use App\Models\Supplier;

class DebtFactory extends Factory
{
    protected $model = Debt::class;

    public function definition()
    {
        $amount = $this->faker->randomFloat(2, 100, 10000);
        $paid = 0;
        $status = ($paid >= $amount) ? 'paid' : 'unpaid';

        return [
            'amount' => $amount,
            'paid' => $paid,
            'remaining' => $amount - $paid,
            'status' => $status,
            'supplier_id' => Supplier::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
            'note' => $this->faker->sentence,
        ];
    }
}
