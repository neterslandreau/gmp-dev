<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('store_nbr')->nullable(); // 0
            $table->string('upc_code')->nullable(); // 1
            $table->string('quantity_sold')->nullable(); // 2
            $table->string('amount_sold')->nullable(); // 3
            $table->string('weight_sold')->nullable(); // 4
            $table->string('sale_date')->nullable(); // 5
            $table->string('department')->nullable(); // 6
            $table->string('enhanced_department')->nullable();
            $table->string('price_qty')->nullable();
            $table->string('price')->nullable();
            $table->string('coupon_type')->nullable();
            $table->string('category')->nullable();
            $table->string('unit_cost')->nullable();
            $table->string('b_value')->nullable();
            $table->string('pos_description')->nullable();
            $table->string('main_link')->nullable();
            $table->string('size')->nullable();
            $table->string('case_cost')->nullable();
            $table->string('wh_item_code')->nullable();
            $table->string('vendor_item_number')->nullable();
            $table->string('price_type')->nullable();
            $table->string('cur_price_qty')->nullable();
            $table->string('cur_price_base')->nullable();
            $table->string('base_unit_cost')->nullable();
            $table->string('base_case_cost')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
