<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class CreateUsersTable extends Migration
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
            $table->string('slug');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->uuid('store_id')->nullable();
            $table->string('password');
            $table->string('role');
            $table->rememberToken();
            $table->timestamps();
        });
        $now = date('Y-m-d H:i:s');
        DB::table('users')->insert([
            'id' => Str::uuid(),
            'role' => 'superuser',
            'first_name' => 'Admin',
            'last_name' => 'IsTrator',
            'slug' => 'admin-istrator',
            'email' => 'kaugustine@intelliwake.com',
            'email_verified_at' => $now,
            'password' => bcrypt('Secr3t'),
            'created_at' => $now,
            'updated_at' => $now

        ]);
        DB::table('users')->insert([
            'id' => Str::uuid(),
            'role' => 'superuser',
            'first_name' => 'Anthony',
            'last_name' => 'Tota',
            'slug' => 'anthony-tota',
            'email' => 'anthony@freshxperts.com',
            'email_verified_at' => $now,
            'password' => bcrypt('Secr3t'),
            'created_at' => $now,
            'updated_at' => $now

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
