<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_belong_to_a_brand()
    {
        // Test with a brand
        $brand = Brand::factory()->create();
        $productWithBrand = Product::factory()->create(['brand_id' => $brand->id]);

        $this->assertInstanceOf(Brand::class, $productWithBrand->brand);
        $this->assertEquals($brand->id, $productWithBrand->brand->id);

        // Test without a brand (brand_id is nullable)
        $productWithoutBrand = Product::factory()->create(['brand_id' => null]);
        $this->assertNull($productWithoutBrand->brand);
    }

    /** @test */
    public function it_can_belong_to_a_category()
    {
        // Test with a category
        $category = Category::factory()->create();
        $productWithCategory = Product::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $productWithCategory->category);
        $this->assertEquals($category->id, $productWithCategory->category->id);

        // Test without a category (category_id is nullable)
        $productWithoutCategory = Product::factory()->create(['category_id' => null]);
        $this->assertNull($productWithoutCategory->category);
    }

    /** @test */
    public function it_can_have_mobile_details()
    {
        // Product that is not a mobile
        $standardProduct = Product::factory()->create(['is_mobile' => false]);
        $this->assertNull($standardProduct->mobileDetail);

        // Product that is a mobile but details not created yet (should be handled by factory config or seeder)
        $mobileProductWithoutDetails = Product::factory()->create(['is_mobile' => true]);
        // Depending on ProductFactory configuration, mobileDetail might be auto-created.
        // If ProductFactory->configure() creates MobileDetail, this assertion might change.
        // For now, assuming it might not exist immediately or we want to test explicit creation.
        
        if ($mobileProductWithoutDetails->mobileDetail()->exists()) {
             $this->assertInstanceOf(\App\Models\MobileDetail::class, $mobileProductWithoutDetails->mobileDetail);
        } else {
            // If factory doesn't auto-create, then create it explicitly for the test
            $mobileDetail = \App\Models\MobileDetail::factory()->create(['product_id' => $mobileProductWithoutDetails->id]);
            $this->assertInstanceOf(\App\Models\MobileDetail::class, $mobileProductWithoutDetails->fresh()->mobileDetail);
            $this->assertEquals($mobileDetail->id, $mobileProductWithoutDetails->fresh()->mobileDetail->id);
        }

        // Product that is mobile and has details
        $mobileProductWithDetails = Product::factory()->create(['is_mobile' => true]);
        $detail = \App\Models\MobileDetail::factory()->create(['product_id' => $mobileProductWithDetails->id]);

        $this->assertInstanceOf(\App\Models\MobileDetail::class, $mobileProductWithDetails->mobileDetail);
        $this->assertEquals($detail->id, $mobileProductWithDetails->mobileDetail->id);
    }

    /** @test */
    public function it_can_be_associated_with_warehouses()
    {
        $product = Product::factory()->create();
        $warehouse1 = \App\Models\Warehouse::factory()->create();
        $warehouse2 = \App\Models\Warehouse::factory()->create();

        // Test initial state (no warehouses)
        $this->assertCount(0, $product->warehouses);

        // Attach warehouses with pivot data
        $product->warehouses()->attach($warehouse1->id, ['stock' => 10, 'stock_alert' => 2]);
        $product->warehouses()->attach($warehouse2->id, ['stock' => 5, 'stock_alert' => 1]);

        $product->refresh(); // Refresh the model to get the loaded relationship

        $this->assertCount(2, $product->warehouses);
        
        $firstWarehousePivot = $product->warehouses()->first()->pivot;
        $this->assertEquals(10, $firstWarehousePivot->stock);
        $this->assertEquals(2, $firstWarehousePivot->stock_alert);

        // Check if we can retrieve a specific warehouse through the relationship
        $retrievedWarehouse1 = $product->warehouses()->where('warehouses.id', $warehouse1->id)->first();
        $this->assertNotNull($retrievedWarehouse1);
        $this->assertEquals($warehouse1->name, $retrievedWarehouse1->name);
        $this->assertEquals(10, $retrievedWarehouse1->pivot->stock);
    }
}
