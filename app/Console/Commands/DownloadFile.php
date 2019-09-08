<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:file {file} {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Provide a method to download files from the ftp server.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ftp_server = '3.82.218.210';
        $ftp_user_name = 'gmpftpuser';
        $ftp_user_pass = 'asdfQWER1234';
        $file = $this->argument('file');

        $path = Storage::disk('local')->path('Import/'.$this->argument('type').'/');
        $myfile = $path.$file;

        $ftph = ftp_connect($ftp_server);
        $login = ftp_login($ftph, $ftp_user_name, $ftp_user_pass);

        $fh = fopen($myfile, 'a+');
        if (ftp_fget($ftph, $fh, $file, FTP_ASCII, 0)) {
            $this->line("successfully written to $myfile");
        } else {
            $this->line("There was a problem while downloading $file to $myfile");
        }

        ftp_close($ftph);
        fclose($fh);
        $this->line('check it');

//        ob_start();
//        $result = ftp_get($ftph, "php://output", $file, FTP_BINARY);
//        $data = ob_get_contents();
//        ob_end_clean();
//
//        dd($data);

    }
}
