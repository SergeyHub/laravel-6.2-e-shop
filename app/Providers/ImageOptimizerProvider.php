<?php

namespace App\Providers;

use App\Services\ImageOptimizer;
use Illuminate\Support\ServiceProvider;

class ImageOptimizerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        ImageOptimizer::Init();
    }
}
