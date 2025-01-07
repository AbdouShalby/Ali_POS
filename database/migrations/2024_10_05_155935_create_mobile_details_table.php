<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('mobile_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->unique();

            $table->string('color')->nullable();
            $table->string('imei')->nullable();
            $table->string('storage')->nullable();
            $table->decimal('battery_health', 5, 2)->nullable();
            $table->string('ram')->nullable();
            $table->string('gpu')->nullable();
            $table->string('cpu')->nullable();
            $table->string('condition')->nullable();
            $table->text('device_description')->nullable();
            $table->boolean('has_box')->default(false);

            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mobile_details');
    }
}
