<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Expense;
use Carbon\Carbon;

class ExpenseSeeder extends Seeder
{
    public function run()
    {
        Expense::factory()->count(50)->create();
    }
}
