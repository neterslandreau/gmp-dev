<?php

namespace App\Console\Commands;

use App\Sales;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sales {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will allow for importing sales from ftp.';

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
        $ftp_server = '3.82.218.210';
        $ftp_user_name = 'gmpftpuser';
        $ftp_user_pass = 'asdfQWER1234';
        $file = $this->argument('file');

        $ftph = ftp_connect($ftp_server);
        $login = ftp_login($ftph, $ftp_user_name, $ftp_user_pass);

        ob_start();
        $result = ftp_get($ftph, "php://output", $file, FTP_BINARY);
        $f = ob_get_contents();
        ob_end_clean();

        $rows = array_map('str_getcsv', explode("\n", $f));
        $this->line(count($rows));
        foreach ($rows as $r => $row) {
            if ($r != 0) {
                if (!isset($row[1])) {
                    break;
                }
                $sales = new Sales([
                    'store_nbr' => $row[0],
                    'upc_code' => $row[1],
                    'quantity_sold' => $row[2],
                    'amount_sold' => $row[3],
                    'weight_sold' => $row[4],
                    'sale_date' => $row[5],
                    'department' => $row[6],
                    'enhanced_department' => $row[7],
                    'price_qty' => $row[8],
                    'price' => $row[9],
                    'coupon_type' => $row[10],
                    'category' => $row[11],
                    'unit_cost' => $row[12],
                    'b_value' => $row[13],
//                    'pos_description' => $row[14],
//                    'main_link' => $row[15],
//                    'size' => $row[16],
//                    'case_cost' => $row[17],
//                    'wh_item_code' => $row[18],
//                    'vendor_item_number' => $row[19],
//                    'price_type' => $row[20],
//                    'cur_price_qty' => $row[21],
//                    'cur_base_price' => $row[22],
//                    'base_unit_cost' => $row[23],
//                    'base_case_cost' => $row[24],
                ]);
                $sales->save();
            }

        }
        $this->line('Completed. Imported ' . count($rows) . ' records');
        unset($rows);
    }
}
