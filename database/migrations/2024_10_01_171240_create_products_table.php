<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name'); // Mandatory
            $table->string('barcode')->unique(); // Mandatory, unique

            $table->decimal('cost', 15, 2); // Mandatory
            $table->decimal('price', 15, 2)->default(0)->nullable(); // Optional
            $table->decimal('wholesale_price', 15, 2)->default(0)->nullable(); // Optional
            $table->decimal('min_sale_price', 15, 2)->default(0)->nullable(); // Optional

            $table->string('image')->nullable(); // Optional
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null'); // Optional
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null'); // Optional

            $table->text('description')->nullable(); // Optional

            $table->boolean('is_mobile')->default(false); // To determine if it's a device

            // Removed fields: client_type, customer_id, supplier_id, payment_method, seller_name, scan_id, scan_documents, qrcode
            // These fields were removed as per new requirements to simplify the product's direct data.
            // scan_id, scan_documents, and qrcode will be part of mobile_details if is_mobile is true.

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
