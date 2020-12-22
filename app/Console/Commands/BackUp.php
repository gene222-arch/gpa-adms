<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class BackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a db backup and project app file in every minute';

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
     * @return int
     */
    public function handle()
    {
        $this->line('==================');
        $this->line('Running my job at ' . Carbon::now());
        $this->line('Ending my job at ' . Carbon::now());
    }
}
