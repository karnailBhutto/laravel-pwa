<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('order_sku', 45)->nullable();
            $table->integer('order_carton')->nullable()->default(0);
            $table->integer('order_pack')->nullable()->default(0);
            $table->string('order_id', 45)->nullable();
            $table->timestamps();
            $table->index(['id', 'order_sku', 'order_carton', 'order_pack', 'order_id', 'created_at', 'updated_at'], 'idx_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
