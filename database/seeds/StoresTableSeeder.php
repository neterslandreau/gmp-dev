<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $natural_foods_upsale = DB::table('store_formats')->where('slug', 'natural-foods-upsale')->value('id');
        $warehouse_store = DB::table('store_formats')->where('slug', 'warehouse-store')->value('id');
        $neighborhood_grocers_full_line = DB::table('store_formats')->where('slug', 'neighborhood-grocers-full-line')->value('id');
        $discount_bare_bones = DB::table('store_formats')->where('slug', 'discount-bare-bones')->value('id');
        $now = date('Y-m-d H:i:s');

        DB::table('stores')->insert([
            'id' => Str::uuid(),
            'name' => 'Store #1',
            'slug' => 'store-1',
            'number' => 1,
            'manager_id' => null,
            'store_format_id' => $warehouse_store,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('stores')->insert([
            'id' => Str::uuid(),
            'name' => 'Store #4',
            'slug' => 'store-4',
            'number' => 4,
            'manager_id' => null,
            'store_format_id' => $warehouse_store,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('stores')->insert([
            'id' => Str::uuid(),
            'name' => 'Store #6',
            'slug' => 'store-6',
            'number' => 6,
            'manager_id' => null,
            'store_format_id' => $natural_foods_upsale,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('stores')->insert([
            'id' => Str::uuid(),
            'name' => 'Store #7',
            'slug' => 'store-7',
            'number' => 7,
            'manager_id' => null,
            'store_format_id' => $natural_foods_upsale,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('stores')->insert([
            'id' => Str::uuid(),
            'name' => 'Store #10',
            'slug' => 'store-10',
            'number' => 10,
            'manager_id' => null,
            'store_format_id' => $neighborhood_grocers_full_line,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
