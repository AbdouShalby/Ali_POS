<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Debt;
use App\Models\Product;
use App\Models\Supplier;

class DebtsTableSeeder extends Seeder
{
    public function run()
    {
        $suppliers = Supplier::all();
        $products = Product::all();

        foreach ($suppliers as $supplier) {
            for ($i = 0; $i < 20; $i++) {
                $product = $products->random();

                $amount = rand(100, 5000);
                $paid = 0;
                $status = ($paid >= $amount) ? 'paid' : 'unpaid';

                Debt::create([
                    'supplier_id' => $supplier->id,
                    'product_id' => $product->id,
                    'amount' => $amount,
                    'paid' => $paid,
                    'status' => $status,
                    'note' => 'Auto-generated debt',
                ]);
            }
        }
    }
}
