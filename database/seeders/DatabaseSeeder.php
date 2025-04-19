<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            BrandsTableSeeder::class,
            CategoriesTableSeeder::class,
            SuppliersTableSeeder::class,
            CustomersTableSeeder::class,
            WarehouseSeeder::class,
            ProductsTableSeeder::class,
            MobileDetailsTableSeeder::class,
            UsersTableSeeder::class,
            CashRegisterSeeder::class,
            SalesTableSeeder::class,
            PurchasesTableSeeder::class,
            PurchaseItemsTableSeeder::class,
            DebtsTableSeeder::class,
            CryptoTransactionSeeder::class,
            MaintenanceSeeder::class,
            CryptoGatewaySeeder::class,
        ]);
    }
}
