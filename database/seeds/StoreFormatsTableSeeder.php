<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoreFormatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        DB::table('store_formats')->insert([
            'id' => Str::uuid(),
            'name' => 'Warehouse Store',
            'description' => 'Costco, Sam\'s Club, BJ\'s, etc..',
            'slug' => 'warehouse-store',
            'created_at' => $now,
            'updated_at' => $now

        ]);
        DB::table('store_formats')->insert([
            'id' => Str::uuid(),
            'name' => 'Discount, bare bones',
            'description' => 'Aldi, Dollar General, Sav A Lot, Dollar Tree, etc..',
            'slug' => 'discount-bare-bones',
            'created_at' => $now,
            'updated_at' => $now

        ]);
        DB::table('store_formats')->insert([
            'id' => Str::uuid(),
            'name' => 'Natural Foods/Upsale',
            'description' => 'Whole Foods, Vitamin College, Natural Grocers etc..',
            'slug' => 'natural-foods-upsale',
            'created_at' => $now,
            'updated_at' => $now

        ]);
        DB::table('store_formats')->insert([
            'id' => Str::uuid(),
            'name' => 'Neighborhood Grocers/Full Line',
            'description' => 'Price Chopper, Hy-Vee, Country Art etc..',
            'slug' => 'neighborhood-grocers-full-line',
            'created_at' => $now,
            'updated_at' => $now

        ]);
    }
}
