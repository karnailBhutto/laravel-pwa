<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outlets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('outlet_id', 45)->nullable();
            $table->string('outlet_sname')->nullable();
            $table->string('outlet_type')->nullable();
            $table->string('outlet_owner')->nullable();
            $table->string('outlet_contact', 45)->nullable();
            $table->string('outlet_region', 45)->nullable();
            $table->string('outlet_province', 45)->nullable();
            $table->string('outlet_district', 45)->nullable();
            $table->string('outlet_postal', 45)->nullable();
            $table->string('outlet_address', 45)->nullable();
            $table->integer('team_id')->nullable();
            $table->string('created_by', 45)->nullable();
            $table->string('updated_by', 45)->nullable();
            $table->timestamps();
            $table->index(['id', 'outlet_id', 'outlet_sname', 'outlet_owner', 'outlet_contact', 'outlet_region', 'outlet_province', 'outlet_district', 'outlet_postal', 'outlet_address', 'created_by', 'created_at', 'updated_by', 'team_id', 'updated_at'], 'index2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outlets');
    }
}
