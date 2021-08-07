<?php

namespace App\Jobs;

use App\Http\Controllers\Api\SyncController;
use App\Models\Product;
use App\Services\API\LibraryConnector;
use App\Services\CatalogService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $products;
    public $ordering;

    public function __construct(Collection $products, $ordering = false)
    {
        $this->products = $products;
        $this->ordering = $ordering;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if (!$this->products->count())
        {
            return;
        }

        $library = new LibraryConnector();

        $remotes = $this->products->pluck('remote_id')->toArray();

        $result = $library->get(Product::all()->pluck("remote_id")->toArray(), ["status", "cases", "prices", "description"]) ?? [];

        $missing = [];

        foreach ($result as $order => $item) {
            /**
             * @var $product Product
             */

            $product = Product::where('remote_id', $item['remote_id'])->first();
            if($product)
            {
                SyncController::fillProductData($product, $this->ordering ? $order : -1, $item);
                $product->save();
            }
            else
            {
                $missing[]=$item['remote_id'];
            }

        }

        CatalogService::makeProductsFromRemote($missing);
        if (count($missing) > 0 && $this->ordering)
        {
            UpdateCatalog::dispatch();
        }
    }
}
