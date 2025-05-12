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
        $cost = $this->faker->randomFloat(2, 10, 500); // Ensure cost is reasonable and not zero
        $price = $cost + $this->faker->randomFloat(2, 5, 200); // Ensure price is greater than cost

        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence,
            'cost' => $cost,
            'price' => $price,
            'wholesale_price' => $this->faker->optional()->randomFloat(2, $cost + 2, $price - 1), // Optional and within cost/price range
            'min_sale_price' => $this->faker->optional()->randomFloat(2, $cost + 1, $price), // Optional and within cost/price range
            'barcode' => $this->faker->unique()->ean13,
            'image' => null, 
            
            'brand_id' => Brand::inRandomOrder()->first()?->id ?? Brand::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            
            'is_mobile' => $this->faker->boolean(30), 
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            if ($product->is_mobile) {
                // If it's a mobile, ensure MobileDetail is created for it.
                // This can be done here or in the ProductSeeder.
                // For simplicity, we can call a MobileDetailFactory here if one exists and is configured.
                if (!\App\Models\MobileDetail::where('product_id', $product->id)->exists()) {
                    \App\Models\MobileDetail::factory()->create([
                        'product_id' => $product->id,
                    ]);
                }
            }
        });
    }
}
