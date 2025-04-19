<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('crypto_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crypto_gateway_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 8);
            $table->decimal('profit_percentage', 5, 2)->nullable();
            $table->string('type'); // 'buy' or 'sell'
            $table->decimal('final_amount', 15, 8);
            $table->decimal('profit_amount', 15, 8);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crypto_transactions');
    }
}
