<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Brand;
use App\Models\Category;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $customers = Customer::all();
        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();

        $products = [
            [
                'name' => 'Samsung Galaxy S21',
                'description' => 'Smartphone from Samsung',
                'cost' => 8000.00,
                'price' => 9000.00,
                'wholesale_price' => 8500.00,
                'min_sale_price' => 8800.00,
                'barcode' => '567890123456',
                'image' => 'product_image_1.jpg',
                'brand_id' => $brands->where('name', 'Samsung')->first()->id,
                'category_id' => $categories->where('name', 'Phones')->first()->id,
                'client_type' => 'customer',
                'customer_id' => $customers->random()->id,
                'supplier_id' => null,
                'payment_method' => 'cash',
                'seller_name' => 'Admin User',
                'is_mobile' => true, // تحديد أن المنتج جهاز
                'mobile_details' => [
                    'color' => 'Black',
                    'storage' => '128GB',
                    'battery_health' => 95,
                    'ram' => '8GB',
                    'gpu' => 'Mali-G78',
                    'cpu' => 'Exynos 2100',
                    'condition' => 'New',
                    'device_description' => 'Excellent condition, no scratches',
                    'has_box' => true,
                ],
            ],
            [
                'name' => 'Apple iPhone 13',
                'description' => 'Smartphone from Apple',
                'cost' => 12000.00,
                'price' => 13000.00,
                'wholesale_price' => 12500.00,
                'min_sale_price' => 12800.00,
                'barcode' => '678901234567',
                'image' => 'product_image_2.jpg',
                'brand_id' => $brands->where('name', 'Apple')->first()->id,
                'category_id' => $categories->where('name', 'Phones')->first()->id,
                'client_type' => 'supplier',
                'customer_id' => null,
                'supplier_id' => $suppliers->random()->id,
                'payment_method' => 'credit',
                'seller_name' => 'Admin User',
                'is_mobile' => true,
                'mobile_details' => [
                    'color' => 'White',
                    'storage' => '256GB',
                    'battery_health' => 100,
                    'ram' => '6GB',
                    'gpu' => 'Apple GPU',
                    'cpu' => 'A15 Bionic',
                    'condition' => 'New',
                    'device_description' => 'Brand new with one-year warranty',
                    'has_box' => true,
                ],
            ],
            [
                'name' => 'Samsung Fast Charger',
                'description' => 'Fast charger with 25W power',
                'cost' => 100.00,
                'price' => 150.00,
                'wholesale_price' => 120.00,
                'min_sale_price' => 130.00,
                'barcode' => '789012345678',
                'image' => 'product_image_3.jpg',
                'brand_id' => $brands->where('name', 'Samsung')->first()->id,
                'category_id' => $categories->where('name', 'Accessories')->first()->id,
                'client_type' => 'supplier',
                'customer_id' => null,
                'supplier_id' => $suppliers->random()->id,
                'payment_method' => 'cash',
                'seller_name' => 'Admin User',
                'is_mobile' => false,
                'mobile_details' => null,
            ],
            [
                'name' => 'Apple AirPods',
                'description' => 'Wireless earphones from Apple',
                'cost' => 1500.00,
                'price' => 2000.00,
                'wholesale_price' => 1800.00,
                'min_sale_price' => 1900.00,
                'barcode' => '890123456789',
                'image' => 'product_image_4.jpg',
                'brand_id' => $brands->where('name', 'Apple')->first()->id,
                'category_id' => $categories->where('name', 'Accessories')->first()->id,
                'client_type' => 'customer',
                'customer_id' => $customers->random()->id,
                'supplier_id' => null,
                'payment_method' => 'credit',
                'seller_name' => 'Admin User',
                'is_mobile' => false,
                'mobile_details' => null,
            ],
        ];

        foreach ($products as $productData) {
            $mobileDetails = $productData['mobile_details'];
            unset($productData['mobile_details']);

            $product = Product::create($productData);

            if ($mobileDetails) {
                $product->mobileDetail()->create($mobileDetails);
            }

            foreach ($warehouses->random(2) as $warehouse) {
                $product->warehouses()->attach($warehouse->id, [
                    'stock' => rand(5, 20),
                    'stock_alert' => rand(1, 5),
                ]);
            }
        }
    }
}
