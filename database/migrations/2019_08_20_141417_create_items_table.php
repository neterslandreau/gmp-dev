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
            $table->string('upc_code');
            $table->string('wh_code');
            $table->string('description');
            $table->string('pack');
            $table->string('size');
            $table->string('quantity');
            $table->string('retail');
            $table->string('gross_margin');
            $table->string('net_cost');
            $table->string('net_case');
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
