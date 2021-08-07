<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizePlaceholderImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:placeholder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        \Tinify\setKey('C5ZZqyg13MSjsy4tyZSD9Q5wcHPnkX5N');
        \Tinify\validate();
        $path = base_path().'/public/images/project/no-photo.jpg';
        $this->warn($path);
        $source = \Tinify\fromFile($path);
        $source->toFile($path);
    }
}
