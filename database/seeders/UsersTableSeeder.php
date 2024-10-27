<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
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
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->syncPermissions($permissions);

        $userRole = Role::firstOrCreate(['name' => 'User']);

        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole($adminRole);
    }
}
