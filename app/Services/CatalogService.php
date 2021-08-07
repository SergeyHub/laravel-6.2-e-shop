<?php

namespace App\Services;

use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumn;
use App\Jobs\UpdateNames;
use App\Jobs\UpdateProducts;
use GuzzleHttp\Client as Http;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use App\Models\{Brand, Product, ProductPrice, Category};

class CatalogService
{
    public static function getMeta($model)
    {
        $meta = [
            'title' =>  $model->meta_title,
            'description' => $model->meta_description,
            'keywords' => $model->meta_keywords,
        ];
        return $meta;
    }
    public static function getMinPrice()
    {
        static $pr = null;
        if (\is_null($pr)) {
            /*
                Мы не можем выбрать просто минимальную цену,
                так как есть разные страны, в них цены могут как указываться,
                так и рассчитываться по курсу из цены в России.
            */
            $prices = ProductPrice::with('product')
                                    ->where('price','>',0)
                                    ->where('country_id',1)
                                    ->where('qty',1)
                                    ->orderBy('price')
                                    ->get();
            $pr = 0;
            foreach ($prices as $key => $price) {
                if ($price->product->status == 1) {
                    $pr = $price->product->getPrice();
                    break;
                }
            }
        }
        return $pr;
    }
    public static function getFrontProducts($amount = 1000)
    {
        return \App\Models\Product::where('status',1)
            ->where('front',1)
            ->take($amount)
            ->orderBy('order')
            ->get();
    }

    public static function makeProductsFromRemote($remotes, $lazy = false)
    {
        $products = new Collection();
        foreach ($remotes as $remote_id) {
            if (Product::where('remote_id', $remote_id)->count() == 0) {
                $product = new Product();

                $product->remote_id = $remote_id;

                $product->under_order = 0;
                //
                $product->status = 0;
                //
                $product->images = [];
                //
                $product->name = "";
                //$product->category_id = Category::get()->first()->id;
                //
                //$product->brand_id = Brand::get()->first()->id;
                //
                //AdminService::setSlug($product);
                //
                $product->save();

                $products->add($product);


            }
        }
        //
        if (!$lazy) {
            UpdateNames::dispatch($products);
            UpdateProducts::dispatch($products);
        }
        //
        return [$products->count(), ""];
    }
}
