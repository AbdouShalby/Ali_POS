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

        $permissions = [
            'manage users',
            'manage roles',
            'manage suppliers',
            'manage customers',
            'manage brands',
            'manage warehouses',
            'manage categories',
            'manage products',
            'manage mobiles',
            'manage purchases',
            'manage external_purchases',
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
    }
}
