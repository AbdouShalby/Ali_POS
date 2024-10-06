<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\MobileDetail;

class MobileDetailsTableSeeder extends Seeder
{
    public function run()
    {
        $productSamsung = Product::where('code', 'SAM-S21')->first();
        $productApple = Product::where('code', 'APL-IP13')->first();

        $mobileDetails = [
            [
                'product_id' => $productSamsung->id,
                'color' => 'أسود',
                'storage' => '128 جيجابايت',
                'battery_health' => 100,
                'ram' => '8 جيجابايت',
                'gpu' => 'Mali-G78',
                'cpu' => 'Exynos 2100',
                'condition' => 'جديد',
                'device_description' => 'هاتف سامسونج جالاكسي S21 جديد كليًا',
                'has_box' => true,
            ],
            [
                'product_id' => $productApple->id,
                'color' => 'أبيض',
                'storage' => '256 جيجابايت',
                'battery_health' => 100,
                'ram' => '6 جيجابايت',
                'gpu' => 'Apple GPU',
                'cpu' => 'A15 Bionic',
                'condition' => 'جديد',
                'device_description' => 'هاتف آيفون 13 جديد مع ضمان سنة',
                'has_box' => true,
            ],
        ];

        foreach ($mobileDetails as $detail) {
            MobileDetail::updateOrCreate(
                ['product_id' => $detail['product_id']],
            );
        }
    }
}
