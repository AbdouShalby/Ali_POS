<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchase;
use App\Models\Supplier;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition()
    {
        return [
            'supplier_id' => Supplier::factory(),
            'invoice_number' => $this->faker->unique()->numerify('INV#####'),
            'purchase_date' => $this->faker->date(),
            'total_amount' => 0,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Purchase $purchase) {
            $items = \App\Models\PurchaseItem::factory()->count(3)->create(['purchase_id' => $purchase->id]);

            $totalAmount = $items->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            $purchase->update(['total_amount' => $totalAmount]);
        });
    }
}
