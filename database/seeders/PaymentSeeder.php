<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Payment;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        Payment::factory()->count(50)->create();
    }
}
