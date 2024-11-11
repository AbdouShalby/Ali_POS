<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Picqer\Barcode\BarcodeGeneratorHTML;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $brandSamsung = Brand::where('name', 'سامسونج')->first();
        $brandApple = Brand::where('name', 'آبل')->first();
        $categoryPhones = Category::where('name', 'هواتف')->first();
        $categoryAccessories = Category::where('name', 'إكسسوارات')->first();

        $products = [
            [
                'name' => 'سامسونج جالاكسي S21',
                'code' => 'SAM-S21',
                'description' => 'هاتف ذكي من سامسونج',
                'cost' => 8000.00,
                'price' => 9000.00,
                'wholesale_price' => 8500.00,
                'min_sale_price' => 8800.00,
                'quantity' => 50,
                'stock_alert' => 10,
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
                'cost' => 12000.00,
                'price' => 13000.00,
                'wholesale_price' => 12500.00,
                'min_sale_price' => 12800.00,
                'quantity' => 30,
                'stock_alert' => 5,
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
            [
                'name' => 'شاحن سامسونج سريع',
                'code' => 'SAM-CHGR',
                'description' => 'شاحن سريع بقوة 25 واط',
                'cost' => 100.00,
                'price' => 150.00,
                'wholesale_price' => 120.00,
                'min_sale_price' => 130.00,
                'quantity' => 100,
                'stock_alert' => 20,
                'brand_id' => $brandSamsung->id,
                'category_id' => $categoryAccessories->id,
            ],
            [
                'name' => 'سماعات آبل AirPods',
                'code' => 'APL-APDS',
                'description' => 'سماعات لاسلكية من آبل',
                'cost' => 1500.00,
                'price' => 2000.00,
                'wholesale_price' => 1800.00,
                'min_sale_price' => 1900.00,
                'quantity' => 50,
                'stock_alert' => 5,
                'brand_id' => $brandApple->id,
                'category_id' => $categoryAccessories->id,
            ],
        ];

        $generator = new BarcodeGeneratorHTML();

        foreach ($products as $productData) {
            $mobileDetails = $productData['mobile_details'] ?? null;
            unset($productData['mobile_details']);

            // Generate unique 13-digit barcode
            $productData['barcode'] = $this->generateUniqueBarcode();

            $product = Product::create($productData);

            if ($mobileDetails) {
                $product->mobileDetail()->updateOrCreate(['product_id' => $product->id], $mobileDetails);
            }
        }
    }

    private function generateUniqueBarcode()
    {
        do {
            $barcode = str_pad(mt_rand(1, 9999999999999), 13, '0', STR_PAD_LEFT);
        } while (Product::where('barcode', $barcode)->exists());

        return $barcode;
    }
}
