<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Customer;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'cost' => $this->faker->randomFloat(2, 50, 1000),
            'price' => $this->faker->randomFloat(2, 100, 2000),
            'wholesale_price' => $this->faker->randomFloat(2, 80, 1800),
            'min_sale_price' => $this->faker->randomFloat(2, 90, 1900),
            'barcode' => $this->faker->unique()->ean13,
            'qrcode' => $this->faker->uuid,
            'image' => 'default_product.jpg',
            'brand_id' => Brand::inRandomOrder()->first()?->id,
            'category_id' => Category::inRandomOrder()->first()?->id,
            'client_type' => $this->faker->randomElement(['customer', 'supplier']),
            'customer_id' => Customer::inRandomOrder()->first()?->id,
            'supplier_id' => Supplier::inRandomOrder()->first()?->id,
            'payment_method' => $this->faker->randomElement(['cash', 'credit']),
            'seller_name' => $this->faker->name,
            'is_mobile' => $this->faker->boolean(30),
            'scan_id' => $this->faker->uuid,
            'scan_documents' => 'document.pdf',
        ];
    }
}
