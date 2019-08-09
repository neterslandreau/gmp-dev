<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class CreateUsersTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->uuid('role_id')->index();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        $now = date('Y-m-d H:i:s');
        DB::table('users')->insert([
            'id' => Str::uuid(),
            'role_id' => '00000000-0000-0000-0000-000000000004',
            'first_name' => 'Admin',
            'last_name' => 'IsTrator',
            'email' => 'kaugustine@intelliwake.com',
            'email_verified_at' => $now,
            'password' => bcrypt('Secr3t')

        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
