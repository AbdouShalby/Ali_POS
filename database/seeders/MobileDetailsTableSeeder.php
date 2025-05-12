<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\MobileDetail;
use Illuminate\Database\Seeder;

class MobileDetailsTableSeeder extends Seeder
{
    public function run()
    {
        // Get all products marked as 'is_mobile' that don't already have mobile details.
        // ProductFactory should now handle creating MobileDetail for new is_mobile products via its configure() method.
        // This seeder can act as a supplement or be removed if factory logic is sufficient.
        $mobileProductsWithoutDetails = Product::where('is_mobile', true)
                                            ->whereDoesntHave('mobileDetail')
                                            ->get();

        if ($mobileProductsWithoutDetails->isEmpty()) {
            $this->command->info('MobileDetailsTableSeeder: No mobile products found needing details, or MobileDetailFactory handled them.');
        }

        foreach ($mobileProductsWithoutDetails as $product) {
            MobileDetail::factory()->create([
                'product_id' => $product->id,
            ]);
        }
    }

    // Example of a helper function, not currently used in run() method and can be removed.
    /* 
    private function getRandomColor()
    {
        $colors = ['Black', 'White', 'Blue', 'Red', 'Green', 'Silver', 'Gold'];
        return $colors[array_rand($colors)];
    }
    */
}
