<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\MobileDetail;
use Illuminate\Database\Seeder;

class MobileDetailsTableSeeder extends Seeder
{
    public function run()
    {
        $products = Product::whereHas('category', function ($query) {
            $query->where('name', 'Phones');
        })->get();

        foreach ($products as $product) {
            MobileDetail::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'color' => 'Black',
                    'storage' => '128GB',
                    'battery_health' => 95,
                    'ram' => '8GB',
                    'gpu' => 'Mali-G78',
                    'cpu' => 'Exynos 2100',
                    'condition' => 'New',
                    'device_description' => 'Excellent condition, no scratches',
                    'has_box' => true,
                ]
            );
        }
    }

    private function getRandomColor()
    {
        $colors = ['Black', 'White', 'Blue', 'Red'];
        return $colors[array_rand($colors)];
    }
}
