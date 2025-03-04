<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Revenue;
use Carbon\Carbon;

class RevenueSeeder extends Seeder
{
    public function run()
    {
        Revenue::factory()->count(50)->create();
    }
}
