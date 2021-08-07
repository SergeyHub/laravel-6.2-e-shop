<?php

namespace App\Jobs;

use App\Http\Controllers\Api\SyncController;
use App\Services\API\LibraryConnector;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \App\Models\{Product, ProductPrice};

/**
 * Class UpdatePrices
 * @package App\Jobs
 *
 * Sync products with remote_id
 *
 */
class UpdatePrices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $products = Product::where('remote_id', '>', 0)->get();
        $remotes = $products->pluck('remote_id')->toArray();

        $library = new LibraryConnector();

        $result = $library->prices($remotes) ?? [];

        foreach ($result as $order => $item) {
            $product = $products->where('remote_id', $item['remote_id'])->first();
            if ($product) {
                SyncController::fillProductData($product, -1, $item);
            }
        }
    }
}
