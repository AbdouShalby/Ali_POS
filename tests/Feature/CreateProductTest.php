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
        $admin = User::factory()->create();
        $admin->assignRole($role);

        $brand = Brand::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->post('/products', [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 50.00,
            'quantity' => 10,
            'brand_id' => $brand->id,
            'category_id' => $category->id,
        ]);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }
}
