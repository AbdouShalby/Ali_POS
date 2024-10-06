<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);

        $permissions = [
            'manage users',
            'manage roles',
            'manage suppliers',
            'manage customers',
            'manage brands',
            'manage categories',
            'manage products',
            'manage mobiles',
            'manage purchases',
            'manage sales',
            'manage accounts',
            'manage units',
            'manage users',
            'manage settings',
            'manage crypto_gateways',
            'manage crypto_transactions',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        $salespersonRole = Role::create(['name' => 'Salesperson']);
        $salespersonRole->givePermissionTo(['manage sales', 'manage customers', 'manage products', 'view reports']);

        $technicianRole = Role::create(['name' => 'Technician']);
        $technicianRole->givePermissionTo(['manage maintenance', 'view reports']);
    }
}
