<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize:images';

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
        $list = [];
        $this->listFolderFiles($list, public_path('images'));
        foreach ($list as $key => $image) {
            app(\Spatie\ImageOptimizer\OptimizerChain::class)->optimize($image);
        }
        echo 'END', PHP_EOL;
    }
    private function listFolderFiles(&$list,$dir){
        $ffs = scandir($dir);
    
        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);
    
        if (count($ffs) < 1)
            return;

        foreach($ffs as $ff){
            if(is_dir($dir.'/'.$ff))  {
                $this->listFolderFiles($list,$dir.'/'.$ff);
            } else {
                if (\strpos(mime_content_type($dir.'/'.$ff),'image') !== false) {
                    $list[] = $dir.'/'.$ff;
                } 
            }
        }
    }
}
