<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $unit = Unit::first(); // افتراضًا نستخدم أول وحدة
        $brandSamsung = Brand::where('name', 'سامسونج')->first();
        $brandApple = Brand::where('name', 'آبل')->first();
        $categoryPhones = Category::where('name', 'هواتف')->first();

        $products = [
            [
                'name' => 'سامسونج جالاكسي S21',
                'code' => 'SAM-S21',
                'description' => 'هاتف ذكي من سامسونج',
                'image' => null,
                'cost' => 8000.00,
                'price' => 9000.00,
                'wholesale_price' => 8500.00,
                'min_sale_price' => 8800.00,
                'quantity' => 50,
                'stock_alert' => 10,
                'unit_id' => $unit->id,
                'sale_unit_id' => $unit->id,
                'purchase_unit_id' => $unit->id,
                'brand_id' => $brandSamsung->id,
                'category_id' => $categoryPhones->id,
                'mobile_details' => [
                    'color' => 'أسود',
                    'storage' => '128GB',
                    'battery_health' => 95,
                    'ram' => '8GB',
                    'gpu' => 'Mali-G78',
                    'cpu' => 'Exynos 2100',
                    'condition' => 'جديد',
                    'device_description' => 'حالة ممتازة، بدون خدوش',
                    'has_box' => true,
                ],
            ],
            [
                'name' => 'آيفون 13',
                'code' => 'APL-IP13',
                'description' => 'هاتف ذكي من آبل',
                'image' => null,
                'cost' => 12000.00,
                'price' => 13000.00,
                'wholesale_price' => 12500.00,
                'min_sale_price' => 12800.00,
                'quantity' => 30,
                'stock_alert' => 5,
                'unit_id' => $unit->id,
                'sale_unit_id' => $unit->id,
                'purchase_unit_id' => $unit->id,
                'brand_id' => $brandApple->id,
                'category_id' => $categoryPhones->id,
                'mobile_details' => [
                    'color' => 'أبيض',
                    'storage' => '256GB',
                    'battery_health' => 100,
                    'ram' => '6GB',
                    'gpu' => 'Apple GPU',
                    'cpu' => 'A15 Bionic',
                    'condition' => 'جديد',
                    'device_description' => 'حالة ممتازة مع علبة وجميع الملحقات',
                    'has_box' => true,
                ],
            ],
        ];

        foreach ($products as $productData) {
            $mobileDetails = $productData['mobile_details'] ?? null;
            unset($productData['mobile_details']);

            $product = Product::create($productData);

            if ($mobileDetails) {
                $product->mobileDetail()->updateOrCreate(['product_id' => $product->id], $mobileDetails);
            }
        }
    }
}
