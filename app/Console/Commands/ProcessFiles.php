<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProcessFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:files {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will download and process all files for the date given. Date format is "mdy" (123119).';

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
        $filestoprocess = [
            'ProduceSales-'.$this->argument('date').'.csv Items',
            'ELVC0004-'.$this->argument('date').'.K Invoices',
            'ELVC0006-'.$this->argument('date').'.K Invoices',
        ];
        $this->line($this->argument('date'));
        $arguments = [
            'file' => 'ELVC0004-'.$this->argument('date').'.K',
            'type' => 'Invoices'
        ];
        $this->call('download:file', $arguments);
        $arguments = [
            'file' => 'ELVC0006-'.$this->argument('date').'.K',
            'type' => 'Invoices'
        ];
        $this->call('download:file', $arguments);
        $arguments = [
            'file' => 'ProduceSales-'.$this->argument('date').'.csv',
            'type' => 'Items'
        ];
        $this->call('download:file', $arguments);
    }
}
