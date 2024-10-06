<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoGatewaysTable extends Migration
{
    public function up()
    {
        Schema::create('crypto_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('balance', 15, 8)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crypto_gateways');
    }
}
