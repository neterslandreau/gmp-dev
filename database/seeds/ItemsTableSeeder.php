<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Item;


class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run()
    {
        $file = Storage::disk('local')->get('ProduceSales-090119.csv');
        $rows = array_map('str_getcsv', explode("\n", $file));
//        dd($rows);
        foreach ($rows as $r => $row) {
            if ($r !== 0) {
                $item = new Item([
                    'store_nbr' => $row[0],
                    'upc_code' => $row[1],
                    'qty_sold' => $row[2],
                    'amt_sold' => $row[3],
                    'weight_sold' => $row[4],
                    'sale_date' => $row[5],
                    'price_qty' => $row[8],
                    'price' => $row[9],
                    'unit_cost' => $row[12],
                    'pos_description' => $row[14],
                    'size' => $row[16],
                    'case_cost' => $row[17],
                    'cur_price_qty' => $row[21],
                    'cur_price' => $row[22],
                    'base_unit_cost' => $row[23],
                    'base_case_cost' => $row[24],
                ]);
                $item->save();
            }
        }
    }
}
