<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\PurchaseItem;

class PurchasesTableSeeder extends Seeder
{
    public function run()
    {
        $suppliers = Supplier::all();

        foreach ($suppliers as $supplier) {
            $purchases = Purchase::factory(5)->create([
                'supplier_id' => $supplier->id,
            ]);

            foreach ($purchases as $purchase) {
                $products = Product::inRandomOrder()->limit(3)->get();

                foreach ($products as $product) {
                    PurchaseItem::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $product->id,
                        'quantity' => rand(1, 10),
                        'price' => $product->price,
                    ]);
                }
            }
        }
    }
}
