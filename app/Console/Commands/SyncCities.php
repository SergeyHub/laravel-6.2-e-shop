<?php

namespace App\Console\Commands;

use App\Jobs\UpdateCities;
use Illuminate\Console\Command;

class SyncCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually run UpdateCities job';

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
        UpdateCities::dispatch();
    }
}
