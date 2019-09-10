<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_totals', function (Blueprint $table) {
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
            $table->string('deal_amount', 7)->nullable();
            $table->string('mbr_case_cost', 7)->nullable();
            $table->string('mbr_ext_case_cost', 7)->nullable();
            $table->string('total_fees', 5)->nullable();
            $table->string('total_retail', 8)->nullable();
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
        Schema::dropIfExists('invoice_totals');
    }
}
