<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_charges', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('invoice_id');
            $table->string('store_nbr', 4)->nullable();
            $table->string('invoice_nbr', 7)->nullable();
            $table->string('delivery_date', 8)->nullable();
            $table->string('cost_ext', 13)->nullable();
            $table->string('deferred_bill_date', 8)->nullable();
            $table->string('deferred_bill_flag', 1)->nullable();
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
        Schema::dropIfExists('delivery_charges');
    }
}
