<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
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
            'manage maintenances',
            'manage devices',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($permissions);
    }
}
