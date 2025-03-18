<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseItem;
use App\Models\Purchase;
use App\Models\Product;

class PurchaseItemsTableSeeder extends Seeder
{
    public function run()
    {
        $purchases = Purchase::all();

        foreach ($purchases as $purchase) {
            $products = Product::inRandomOrder()->limit(3)->get();

            foreach ($products as $product) {
                PurchaseItem::factory()->create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
