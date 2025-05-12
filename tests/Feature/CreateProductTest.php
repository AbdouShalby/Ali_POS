<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_a_product()
    {
        $this->withoutExceptionHandling();

        $role = Role::create(['name' => 'Admin']);
        $permission = Permission::create(['name' => 'manage products']);
        $role->givePermissionTo($permission);
        $admin = User::factory()->createOne(); // Use createOne for clarity
        $admin->assignRole($role);

        $brand = Brand::factory()->create();
        $category = Category::factory()->create();
        $warehouse = \App\Models\Warehouse::factory()->create(); // Create a warehouse for testing

        $productData = [
            'name' => 'Test Product Standard',
            'barcode' => '1234567890123',
            'cost' => 25.00,
            'price' => 50.00, // Optional but good to test
            'description' => 'Test Standard Product Description',
            'brand_id' => $brand->id, // Optional
            'category_id' => $category->id, // Optional
            'is_mobile' => false,
            'warehouses' => [
                [
                    'id' => $warehouse->id,
                    'stock' => 10,
                    'stock_alert' => 2,
                ]
            ]
        ];

        $response = $this->actingAs($admin)->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product Standard',
            'barcode' => '1234567890123',
            'cost' => 25.00,
            'is_mobile' => false,
        ]);

        // Assert that the product is associated with the warehouse
        $createdProduct = \App\Models\Product::where('barcode', '1234567890123')->first();
        $this->assertNotNull($createdProduct, "Product was not created.");
        $this->assertDatabaseHas('product_warehouse', [
            'product_id' => $createdProduct->id,
            'warehouse_id' => $warehouse->id,
            'stock' => 10,
            'stock_alert' => 2,
        ]);
    }

    /** @test */
    public function admin_can_create_a_device_product()
    {
        $this->withoutExceptionHandling();

        $role = Role::create(['name' => 'Admin']);
        Permission::findOrCreate('manage products', 'web'); // Ensure permission exists
        $role->givePermissionTo('manage products');
        $admin = User::factory()->createOne();
        $admin->assignRole($role);

        $category = Category::factory()->create();
        $warehouse = \App\Models\Warehouse::factory()->create();
        // For file uploads, we need to use UploadedFile::fake()
        // For scan_id and scan_documents, they are part of mobile_details now.
        // The controller handles storing them if 'is_mobile' is true.

        $deviceData = [
            'name' => 'Test Device iPhone',
            'barcode' => '9876543210123',
            'cost' => 700.00,
            'price' => 999.00,
            'category_id' => $category->id,
            'is_mobile' => true,
            // MobileDetail specific fields (sent in the same request)
            'color' => 'Space Gray',
            'storage' => '256GB',
            'battery_health' => 98,
            'ram' => '6GB',
            'condition' => 'Like New',
            'has_box' => true,
            // 'scan_id' => UploadedFile::fake()->image('scan_id.jpg'), // Example for file upload
            // 'scan_documents' => UploadedFile::fake()->create('docs.pdf', 100, 'application/pdf'), // Example for file upload
            'warehouses' => [
                [
                    'id' => $warehouse->id,
                    'stock' => 5,
                    'stock_alert' => 1,
                ]
            ]
        ];

        $response = $this->actingAs($admin)->post(route('products.store'), $deviceData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Test Device iPhone',
            'barcode' => '9876543210123',
            'cost' => 700.00,
            'is_mobile' => true,
        ]);

        $createdProduct = \App\Models\Product::where('barcode', '9876543210123')->first();
        $this->assertNotNull($createdProduct, "Device product was not created.");

        $this->assertDatabaseHas('mobile_details', [
            'product_id' => $createdProduct->id,
            'color' => 'Space Gray',
            'storage' => '256GB',
            'battery_health' => 98,
            'ram' => '6GB',
            'condition' => 'Like New',
            'has_box' => true,
            // 'scan_id' => expected path if uploaded, // This needs more complex assertion or checking for file existence
            // 'qrcode' => should be null or a path if generated synchronously (it's async now)
        ]);
        
        // Check if QR code was generated (it's async, so it might not be there immediately)
        // For testing async QR, we might need to use Mocks or test the job dispatching.
        // For now, we can check if the mobile_detail record has a qrcode path after a short delay or by re-fetching.
        // Or, more robustly, listen for an event if QR generation dispatches one.
        // As generateOrUpdateDeviceQRCode saves to mobile_detail->qrcode, we can check it.
        // However, the dispatch()->afterResponse() means it won't be there in this synchronous test flow.
        // To test QR generation properly, a separate test for the QR generation logic might be better,
        // or using `Bus::fake()` to assert the job was dispatched.

        // Assert warehouse association
        $this->assertDatabaseHas('product_warehouse', [
            'product_id' => $createdProduct->id,
            'warehouse_id' => $warehouse->id,
            'stock' => 5,
            'stock_alert' => 1,
        ]);
    }
}
