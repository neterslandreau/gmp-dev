<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        $now = date('Y-m-d H:i:s');
        DB::table('roles')->insert([
            'id' => '00000000-0000-0000-0000-000000000001',
            'name' => 'user',
            'description' => 'Normal user belongsTo Store.',
            'created_at' => $now,
            'updated_at' => $now,

        ]);

        DB::table('roles')->insert([
            'id' => '00000000-0000-0000-0000-000000000002',
            'name' => 'manager',
            'description' => 'Manager user belongsTo Store.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('roles')->insert([
            'id' => '00000000-0000-0000-0000-000000000003',
            'name' => 'regionaluser',
            'description' => 'Regional manager over group of stores.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('roles')->insert([
            'id' => '00000000-0000-0000-0000-000000000004',
            'name' => 'superuser',
            'description' => 'Full control over the application including users and all stores.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
