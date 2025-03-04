<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CryptoTransaction;

class CryptoTransactionSeeder extends Seeder
{
    public function run()
    {
        CryptoTransaction::factory()->count(50)->create();
    }
}
