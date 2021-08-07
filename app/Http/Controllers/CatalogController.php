<?php

namespace App\Http\Controllers;

use App\Services\CatalogResolverService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use \App\Models\{Category, Brand, Set, SetProduct, SetCategory, Product, Page, Meta};

class CatalogController extends Controller
{
    public function resolver($slugLine = null)
    {
        return resolver()->resolve($this, $slugLine ? explode('/', $slugLine) : []);
    }

    public function show(Collection $products)
    {

        /* META */
        $minPrice = $products->min('price');

        if (!resolver()->chain()) {
            meta('catalog.index')->with([
                '%min_price%' => $minPrice,
            ]);
            $pageTitle = 'Каталог осциллографов';
        } else {
            meta('catalog.chain')->with([
                '%min_price%' => $minPrice,
                '%chain%' => resolver()->textAppend,

            ]);
            $pageTitle = 'Осциллографы '.resolver()->textAppend;
        }

        $pageAppend = resolver()->textAppendPage;
        meta()->with(['%page%' => $pageAppend]);

        breadcrumbs()
            ->root()
            ->to("Каталог");
        if (\request()->ajax()) {
            $count = filters()->count;
            return [
                "controls" => filters()->controls(),
                "url" => resolver()->currentUrl(),
                "teasers" => view("shared.product.teasers")->with("products", $products)->render(),
                //"pagination" => view("pages.catalog._partials.pagination")->render(),
                "breadcrumbs" => view("shared.breadcrumb")->render(),
                //"filters" => view("pages.catalog._partials.filters")->render(),
                "count" => "Найдено товаров: <strong class=\"ml-2\">{$count}</strong>",
                "heading" => $pageTitle,
                "title" => rv(meta()->title),
            ];
        }
        $view = 'catalog-view';

        return view('pages.catalog.index', compact('products', 'view', 'pageTitle'));
    }

    public function set($set)
    {
        if (!$set) {
            abort(404);
        }

        $products = \App\Models\Product::where('status', 1)->orderBy('order');
        $pids = \App\Models\SetProduct::where('set_id', $set->id)
            ->get()
            ->pluck('product_id')
            ->unique()
            ->toArray();

        /* META */
        $minPrice = \App\Models\ProductPrice::whereIn('product_id', $pids)->where('qty', 1)->min('price');

        meta()
            ->using($set)
            ->using('set')
            ->using('category')
            ->with([
                "%title%" => $set->name,
                "%min_price%" => $minPrice
            ]);

        breadcrumbs()
            ->root()
            ->to("Каталог", route('catalog.show'))
            ->to($set->name);

        $pageTitle = $set->name;
        $pids = \App\Models\SetProduct::where('set_id', $set->id)
            ->get()
            ->unique('product_id')
            ->pluck('product_id')
            ->toArray();
        $products = \App\Models\Product::with('categories')
            ->where('status', 1)
            ->orderBy('order')
            ->get();
        $products = $products->whereIn('id', $pids);
        $categories = Category::where('status', 1)->orderBy('order')->get();
        $current = null;
        $showAll = false;
        $category = (object)['id' => 0, 'sets' => null];
        return view('pages.catalog.index', compact('pageTitle', 'category', 'products', 'categories', 'showAll'));

    }

    public function brand($brand)
    {

        if ($brand) {
            $products = $brand->products->where('status', 1)
                ->sortBy('order');
            $pids = $products->pluck('id')->toArray();

            /* META */
            $minPrice = \App\Models\ProductPrice::whereIn('product_id', $pids)->where('qty', 1)->min('price');

            meta()
                ->using($brand)
                ->using('brand')
                ->using('catalog')
                ->with([
                    "%min_price%" => $minPrice
                ]);

            breadcrumbs()
                ->root()
                ->to("Каталог", route('catalog.show'))
                ->to($brand->name);

            $pageTitle = $brand->name;

            $products = Product::whereIn('id', $pids)->orderBy('order');


            $products = $products->paginate($brand->paginate ?? cv('paginate'));
            $productsCount = $products->count();

            return view('pages.catalog.index', compact('pageTitle', 'brand', 'products'));
        } else {
            abort(404);
        }
    }

    public function productFind($catalogSlug, $slug)
    {
        $product = Product::where('slug', $slug)->where('status', 1)->first();
        return $this->product($product);
    }

    public function product($product)
    {
        if (!$product) {
            abort(404);
        }

        /* META */
        meta()
            ->using($product)
            ->using('product')
            ->with($product);

        breadcrumbs()
            ->root()
            ->to('Каталог', '/catalog');
        if ($filter = $product->filters->where("group.chained", 1)->first()) {
            breadcrumbs()->to($filter->name, route('catalog.show', [$filter->alias]));
        }
        breadcrumbs()->to($product->name);

        $view = 'productcard';
        $title = $product->name;
        return view('pages.catalog.product', compact('product', 'view', 'title'));
    }

    public function showPage($page)
    {

        currentCity();
        if ($page) {
            /* META */
            meta($page);
            breadcrumbs()
                ->root()
                ->to($page->title);

            return view('pages.' . $page->view, [
                'page' => $page,
                'title' => $page->title,
                'view' => str_replace('.', '-', $page->view),
            ]);
        } else {
            abort(404);
        }
    }

    public function market()
    {
        $products = Product::orderBy('order')->get();
        $categories = Category::orderBy('order')->get();
        $content = \View::make('xml.market', ['products' => $products, 'categories' => $categories]);

        return \Response::make($content, '200')->header('Content-Type', 'text/xml');
    }
}
