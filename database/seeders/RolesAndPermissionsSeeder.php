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
            'manage maintenances',
            'manage devices',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($permissions);

        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'manage products',
            'manage crypto gateways',
            'buy crypto',
            'sell crypto',
        ]);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'buy crypto',
            'sell crypto',
        ]);
    }
}
