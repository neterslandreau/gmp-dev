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
            'name' => 'Costco',
            'slug' => 'costco',
            'manager_id' => null,
            'store_format_id' => $warehouse_store,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('stores')->insert([
            'id' => Str::uuid(),
            'name' => 'Sam\'s Club',
            'slug' => 'sam-s-club',
            'manager_id' => null,
            'store_format_id' => $warehouse_store,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('stores')->insert([
            'id' => Str::uuid(),
            'name' => 'Whole Foods',
            'slug' => 'whole-foods',
            'manager_id' => null,
            'store_format_id' => $natural_foods_upsale,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('stores')->insert([
            'id' => Str::uuid(),
            'name' => 'Vitamin College',
            'slug' => 'vitamin-college',
            'manager_id' => null,
            'store_format_id' => $natural_foods_upsale,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('stores')->insert([
            'id' => Str::uuid(),
            'name' => 'Price Chopper',
            'slug' => 'price-chopper',
            'manager_id' => null,
            'store_format_id' => $neighborhood_grocers_full_line,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('stores')->insert([
            'id' => Str::uuid(),
            'name' => 'Hi-Vee',
            'slug' => 'hi-vee',
            'manager_id' => null,
            'store_format_id' => $neighborhood_grocers_full_line,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('stores')->insert([
            'id' => Str::uuid(),
            'name' => 'Dollar General',
            'slug' => 'dollar-general',
            'manager_id' => null,
            'store_format_id' => $discount_bare_bones,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('stores')->insert([
            'id' => Str::uuid(),
            'name' => 'Aldi',
            'slug' => 'aldi',
            'manager_id' => null,
            'store_format_id' => $discount_bare_bones,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
