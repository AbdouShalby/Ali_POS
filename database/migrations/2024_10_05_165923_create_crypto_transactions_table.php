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
            $table->unsignedBigInteger('crypto_gateway_id');
            $table->enum('type', ['buy', 'sell']);
            $table->decimal('amount', 15, 8);
            $table->boolean('includes_fees')->default(false);
            $table->timestamps();

            $table->foreign('crypto_gateway_id')->references('id')->on('crypto_gateways')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('crypto_transactions');
    }
}
