<?php

namespace App\Jobs;

use App\Http\Controllers\Api\SyncController;
use App\Models\Product;
use App\Services\API\LibraryConnector;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCatalog implements ShouldQueue
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
        $library = new LibraryConnector();

        $products = Product::where('remote_id', '>', 0)->get();
        $remotes = $products->pluck('remote_id')->toArray();

        $result = $library->status($remotes) ?? [];

        foreach ($result as $order=>$item) {
            $product = $products->where('remote_id', $item['remote_id'])->first();
            SyncController::fillProductData($product, $order, $item);
            $product->save();
        }
    }
}
