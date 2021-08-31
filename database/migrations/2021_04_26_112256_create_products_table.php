<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('idproduct', true);
            $table->integer('category_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('product_sku', 155)->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_description')->nullable();
            $table->string('item_type', 45)->nullable();
            $table->string('product_type', 95)->nullable();
            $table->string('product_uom', 45)->nullable();
            $table->integer('product_country')->nullable();
            $table->string('product_currency', 45)->nullable();
            $table->string('product_price', 45)->nullable();
            $table->string('product_barcode', 155)->nullable();
            $table->string('product_image', 45)->nullable();
            $table->string('product_quantity', 45)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->index(['idproduct', 'category_id', 'brand_id', 'product_sku', 'product_name', 'product_description', 'item_type', 'product_type', 'product_image', 'product_quantity', 'created_at', 'updated_at'], 'idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
