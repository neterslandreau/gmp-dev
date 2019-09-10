<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderExemptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_exemptions', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('invoice_id');
            $table->string('store_nbr', 4)->nullable();
            $table->string('invoice_nbr', 7)->nullable();
            $table->string('retail_dept', 3)->nullable();
            $table->string('delivery_date', 8)->nullable();
            $table->string('case_qty_billed', 5)->nullable();
            $table->string('cost_ext', 13)->nullable();
            $table->string('deferred_bill_date', 8)->nullable();
            $table->string('deferred_bill_flag', 1)->nullable();
            $table->string('upc_code', 15)->nullable();
            $table->string('facility', 2)->nullable();
            $table->string('whse', 2)->nullable();
            $table->string('item_code_ckdgt_bil', 6)->nullable();
            $table->string('item_code_ckdgt_ord', 6)->nullable();
            $table->string('sub_code', 1)->nullable();
            $table->string('reject_code', 4)->nullable();
            $table->string('item_desc', 23)->nullable();
            $table->string('ba_retail_ext', 8)->nullable();
            $table->string('deal_amount', 7)->nullable();
            $table->string('picking_slot', 6)->nullable()->nullable();
            $table->string('size', 6)->nullable();
            $table->string('pack', 5)->nullable();
            $table->string('retail_price', 7)->nullable();
            $table->string('retail_pricing_unit', 3)->nullable();
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
        Schema::dropIfExists('order_exemptions');
    }
}
