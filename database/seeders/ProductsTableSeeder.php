<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        Product::factory(20)->create()->each(function ($product) {
            if ($product->is_mobile) {
                $product->update([
                    'scan_id' => $product->barcode,
                    'scan_documents' => 'mobile_doc.pdf',
                ]);
            }
        });

        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();

        Product::all()->each(function ($product) use ($suppliers, $warehouses) {
            if ($suppliers->isNotEmpty()) {
                $product->update(['supplier_id' => $suppliers->random()->id]);
            }

            if ($warehouses->isNotEmpty()) {
                $product->warehouses()->attach($warehouses->random()->id, [
                    'stock' => rand(5, 20),
                    'stock_alert' => rand(1, 5),
                ]);
            }
        });
    }
}
