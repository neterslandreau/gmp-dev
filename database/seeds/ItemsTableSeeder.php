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
        $file = Storage::disk('local')->get('master_list_070219_1.csv');
        $rows = array_map('str_getcsv', explode("\n", $file));
//        dd($rows);
        foreach ($rows as $r => $row) {
            if ($r !== 0) {
                $item = new Item([
                    'upc_code' => $row[0],
                    'wh_code' => $row[1],
                    'description' => $row[3],
                    'pack' => $row[4],
                    'size' => $row[5],
                    'quantity' => $row[6],
                    'retail' => $row[7],
                    'gross_margin' => $row[10],
                    'net_cost' => $row[15],
                    'net_case' => $row[32],
                ]);
                $item->save();
            }
        }
    }
}
