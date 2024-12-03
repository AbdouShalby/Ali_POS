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

            $table->string('name');
            $table->string('barcode')->nullable()->unique();

            $table->decimal('cost', 15, 2);
            $table->decimal('price', 15, 2);
            $table->decimal('wholesale_price', 15, 2);
            $table->decimal('min_sale_price', 15, 2);

            $table->string('image')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');

            $table->text('description')->nullable();

            $table->boolean('is_mobile')->default(false);

            $table->string('client_type')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->string('payment_method')->nullable();

            $table->string('seller_name')->nullable();
            $table->string('scan_id')->nullable();
            $table->string('scan_documents')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
