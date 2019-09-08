<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('slug');
            $table->string('store_nbr');
            $table->string('upc_code');
            $table->integer('qty_onhand')->default(0);
            $table->string('qty_sold');
            $table->string('amt_sold');
            $table->string('weight_sold');
            $table->string('sale_date');
            $table->string('price_qty');
            $table->string('price');
            $table->string('unit_cost');
            $table->string('pos_description');
            $table->string('size');
            $table->string('case_cost');
            $table->string('cur_price_qty');
            $table->string('cur_price');
            $table->string('base_unit_cost');
            $table->string('base_case_cost');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
