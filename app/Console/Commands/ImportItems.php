<?php

namespace App\Console\Commands;

use App\Item;
use Cviebrock\EloquentSluggable\Sluggable;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:items {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will allow to import items from ftp.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        function newItem(array $row) {
            $item = new Item();
            $item->store_nbr = $row[0];
            $item->upc_code = $row[1];
            $item->qty_sold = $row[2];
            $item->amt_sold = $row[3];
            $item->weight_sold = $row[4];
            $item->sale_date = $row[5];
            $item->price_qty = $row[8];
            $item->price = $row[9];
            $item->unit_cost = $row[12];
            $item->pos_description = $row[14];
            $item->size = $row[16];
            $item->case_cost = $row[17];
            $item->case_cost = $row[17];
            $item->cur_price_qty = $row[21];
            $item->cur_price = $row[22];
            $item->base_unit_cost = $row[23];
            $item->base_case_cost = $row[24];
            $item->save();
            return $item->store_id;
        }

        $created = 0;
        $updated = 0;
        $price_change = 0;
        $ids_created = [];
        $ids_pricing = [];
        $ids_sales = [];

        $f = Storage::disk('local')->get('Import/Items/'.$this->argument('file'));
        $rows = array_map('str_getcsv', explode("\n", $f));
        $total = count($rows);
//        $this->line(count($rows));
        $bar = $this->output->createProgressBar(count($rows));
        foreach ($rows as $r => $row) {
            if ($r !== 0) {
                if (!isset($row[1])) {
                    break;
                }
                $slug = SlugService::createSlug(Item::class, 'slug', $row[14].' '.$row[0].$row[1], ['unique' => false]);
                $item = Item::where('slug', '=', $slug)->first();
//                dd($item);
                if ($item) {
                    if ((int)$row[2]) {
                        $ids_sales[$r] = $item->id;
//                        $this->line('item id: '.$item->id);
                        $oldv = $item->qty_onhand;
                        $diff = $oldv - (int)$row[2];
//                        $this->line('diff: '.$diff);
                        $item->qty_onhand = $diff;
                        $item->save();
                        $updated++;
                    }
                    if ( trim($row[22]) !== trim($item->cur_price) ) {
                        $ids_pricing[$r] = $item->id;
                        $item->cur_price = trim($row[22]);
                        $price_change++;
                    }
                } else {
                    $ids_created[$r] = newItem($row);
                    $created++;
                    }
                }
                $bar->advance();
            }
        $bar->finish();
//        $this->log($ids_created);
//        $this->log($ids_pricing);
//        $this->log($ids_sales);

        $this->info("\n".'Total Lines in file: '.$total);
        $this->comment('No. Items created: '.$created);
        $this->comment('No. Items updated on-hand: '.$updated);
        $this->comment('NO. Items SRP changed: '.$price_change);
        unset($rows);


//        $this->line("Some text");
//        $this->info("Hey, watch this !");
//        $this->comment("Just a comment passing by");
//        $this->question("Why did you do that?");
//        $this->error("Ops, that should not happen.");
    }

}
