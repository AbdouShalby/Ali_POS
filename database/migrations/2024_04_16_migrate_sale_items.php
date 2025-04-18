<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // نقل البيانات من sale_items إلى sale_details
        $saleItems = DB::table('sale_items')->get();
        
        foreach ($saleItems as $item) {
            DB::table('sale_details')->insert([
                'sale_id' => $item->sale_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'total_price' => $item->price * $item->quantity,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ]);
        }
    }

    public function down()
    {
        // حذف البيانات المنقولة من sale_details
        DB::table('sale_details')->truncate();
    }
}; 