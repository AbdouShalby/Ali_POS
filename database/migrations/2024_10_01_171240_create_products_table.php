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
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->decimal('cost', 15, 2);
            $table->decimal('price', 15, 2);
            $table->decimal('wholesale_price', 15, 2);
            $table->decimal('min_sale_price', 15, 2);

            $table->integer('quantity');
            $table->integer('stock_alert')->default(0);

            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('seller_name')->nullable();
            $table->string('scan_id')->nullable();
            $table->string('scan_documents')->nullable();

            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
