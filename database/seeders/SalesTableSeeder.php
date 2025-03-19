<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;

class SalesTableSeeder extends Seeder
{
    public function run()
    {
        $customers = Customer::all();
        $products = Product::all();

        if ($customers->isEmpty() || $products->isEmpty()) {
            return;
        }

        Sale::factory(50)->create()->each(function ($sale) use ($products) {
            $selectedProducts = $products->random(rand(1, 3));

            foreach ($selectedProducts as $product) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 5),
                    'price' => $product->price,
                ]);
            }
        });
    }
}
