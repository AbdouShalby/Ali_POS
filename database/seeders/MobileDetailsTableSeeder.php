<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\MobileDetail;

class MobileDetailsTableSeeder extends Seeder
{
    public function run()
    {
        $productSamsung = Product::where('name', 'Samsung Galaxy S21')->first();
        $productApple = Product::where('name', 'iPhone 13')->first();

        $mobileDetails = [
            [
                'product_id' => $productSamsung->id,
                'color' => 'Black',
                'storage' => '128GB',
                'battery_health' => 100,
                'ram' => '8GB',
                'gpu' => 'Mali-G78',
                'cpu' => 'Exynos 2100',
                'condition' => 'New',
                'device_description' => 'Brand new Samsung Galaxy S21 smartphone',
                'has_box' => true,
            ],
            [
                'product_id' => $productApple->id,
                'color' => 'White',
                'storage' => '256GB',
                'battery_health' => 100,
                'ram' => '6GB',
                'gpu' => 'Apple GPU',
                'cpu' => 'A15 Bionic',
                'condition' => 'New',
                'device_description' => 'Brand new iPhone 13 with one-year warranty',
                'has_box' => true,
            ],
        ];

        foreach ($mobileDetails as $detail) {
            MobileDetail::updateOrCreate(
                ['product_id' => $detail['product_id']],
                $detail
            );
        }
    }
}
