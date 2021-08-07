<?php

namespace App\Jobs;

use App\Services\API\LibraryConnector;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $products;

    public function __construct(Collection $products)
    {
        $this->products = $products;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [];
        foreach ($this->products as $product) {
            $item = [
                'remote_id'=>$product->remote_id,
                'description' => [],
                'cases' => []
            ];

            //store description
            foreach (config("crm.fields") as $remote => $local) {
                if (!is_null($product->$local)) {
                    $item['description'][$remote] = $product->$local;
                }
            }

            //store cases

            if (strlen($product->name) > 0) {
                $item['cases'][0] = $product->name;
            }

            if (strlen($product->name1) > 0) {
                $item['cases'][1] = $product->name1;
            }

            if (strlen($product->name2) > 0) {
                $item['cases'][2] = $product->name2;
            }

            if (strlen($product->name3) > 0) {
                $item['cases'][3] = $product->name3;
            }

            if (strlen($product->name4) > 0) {
                $item['cases'][4] = $product->name4;
            }
            if (strlen($product->name5) > 0) {
                $item['cases'][5] = $product->name5;
            }

            //store
            $data[]=$item;
        }

        $library = new LibraryConnector();
        $library->send($data);
    }
}
