<?php

namespace App\Console\Commands;

use App\Jobs\UpdateNames;
use Illuminate\Console\Command;

class SyncNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:names';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually run UpdateNames job';

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
        UpdateNames::dispatch();
    }
}
