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
     *
     */
    public function handle()
    {
        Storage::disk('local')->put('Import/'.$this->argument('type').'/'.$this->argument('file'), Storage::disk('ftp')->get($this->argument('file')));
        $this->comment('File downloaded. Import will start.');
        $this->call('import:'.strtolower($this->argument('type')), ['file' => $this->argument('file')]);
    }
}
