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
            // $table->string('imei')->nullable(); // Removed as per new requirements
            $table->string('storage')->nullable();
            $table->decimal('battery_health', 5, 2)->nullable();
            $table->string('ram')->nullable();
            $table->string('gpu')->nullable();
            $table->string('cpu')->nullable();
            $table->string('condition')->nullable(); // e.g., New, Used - Like New
            $table->text('device_description')->nullable(); // Additional details about the device
            $table->boolean('has_box')->default(false);

            // New fields for device-specific QR code and scanned documents
            $table->string('qrcode')->nullable(); // Path to the QR code image for the device
            $table->string('scan_id')->nullable(); // Path to the scanned ID image
            $table->string('scan_documents')->nullable(); // Path to the scanned documents

            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mobile_details');
    }
}
