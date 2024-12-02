<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\MobileDetail;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $brandSamsung = Brand::firstWhere('name', 'Samsung');
        $brandApple = Brand::firstWhere('name', 'Apple');
        $categoryPhones = Category::firstWhere('name', 'Phones');
        $supplier = Supplier::first();
        $customer = Customer::first();
        $warehouses = Warehouse::all();

        $products = [
            [
                'name' => 'Samsung Galaxy S21',
                'barcode' => $this->generateUniqueBarcode(),
                'description' => 'Smartphone from Samsung',
                'cost' => 8000.00,
                'price' => 9000.00,
                'wholesale_price' => 8500.00,
                'min_sale_price' => 8800.00,
                'quantity' => 50,
                'stock_alert' => 10,
                'brand_id' => $brandSamsung->id,
                'category_id' => $categoryPhones->id,
                'warehouse_id' => $warehouses->random()->id,
                'supplier_id' => $supplier->id,
                'customer_id' => $customer->id,
                'payment_method' => 'cash',
                'seller_name' => 'Admin User',
                'scan_id' => 'scan_id_example.pdf',
                'scan_documents' => 'scan_documents_example.pdf',
                'image' => 'product_image.jpg',
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
        ];

        foreach ($products as $productData) {
            $mobileDetails = $productData['mobile_details'] ?? null;
            unset($productData['mobile_details']);

            $product = Product::create($productData);

            if ($mobileDetails) {
                $product->mobileDetail()->create($mobileDetails);
            }

            foreach ($warehouses->random(2) as $warehouse) {
                $product->warehouses()->attach($warehouse->id, ['stock' => rand(1, 20)]);
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
