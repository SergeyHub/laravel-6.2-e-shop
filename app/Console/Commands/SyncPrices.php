<?php

namespace App\Console\Commands;

use App\Jobs\UpdatePrices;
use Illuminate\Console\Command;

class SyncPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually run UpdatePrices job';

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
        UpdatePrices::dispatch();
    }
}
