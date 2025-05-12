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
        // Create 20 products. If a product is_mobile, ProductFactory's configure() method
        // will attempt to create an associated MobileDetail record using MobileDetailFactory.
        Product::factory(20)->create(); 

        // as these are now part of MobileDetail and handled by its factory (or will be null/placeholders).

        $warehouses = Warehouse::all();

        if ($warehouses->isNotEmpty()) {
            Product::all()->each(function ($product) use ($warehouses) {
                // Attach each product to one or more random warehouses with random stock
                $numberOfWarehousesToAttach = rand(1, min(3, $warehouses->count()));
                $randomWarehouses = $warehouses->random($numberOfWarehousesToAttach);

                foreach ($randomWarehouses as $warehouse) {
                    // Ensure we don't attach the same warehouse multiple times in this loop if $numberOfWarehousesToAttach > 1
                    // However, ->attach will handle duplicates gracefully if primary keys are set up on pivot.
                    // For simplicity, random selection might pick the same warehouse if count is low.
                    if (!$product->warehouses()->where('warehouse_id', $warehouse->id)->exists()){
                        $product->warehouses()->attach($warehouse->id, [
                            'stock' => rand(5, 100), // Increased stock range
                            'stock_alert' => rand(1, 10), // Increased stock_alert range
                        ]);
                    }
                }
            });
        } else {
            $this->command->info('No warehouses found. Products will not be assigned to any warehouse.');
        }
    }
}
