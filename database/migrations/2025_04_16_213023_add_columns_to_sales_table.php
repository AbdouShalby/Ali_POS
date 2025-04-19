<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            if (!Schema::hasColumn('sales', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('sales', 'discount_amount')) {
                $table->decimal('discount_amount', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('sales', 'tax_percentage')) {
                $table->decimal('tax_percentage', 5, 2)->default(0);
            }
            if (!Schema::hasColumn('sales', 'tax_amount')) {
                $table->decimal('tax_amount', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('sales', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn([
                'subtotal',
                'discount_amount',
                'tax_percentage',
                'tax_amount',
                'total_amount'
            ]);
        });
    }
}; 