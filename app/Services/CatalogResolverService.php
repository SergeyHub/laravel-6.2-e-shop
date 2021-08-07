<?php


namespace App\Services;

/*
 * Resolve catalog requests and run specified controller method
 *
 * SHARED COMPONENT! EDIT ONLY IF YOU PLANED GLOBAL UPDATE!
 */

use App\Models\Filter;
use App\Http\Controllers\CatalogController;
use App\Models\FilterGroup;
use App\Models\Product;
use App\Models\Set;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\DB;
use test\Mockery\ReturnTypeObjectTypeHint;

class CatalogResolverService
{
    private static $instance = null;
    public $chain = null;
    public $textAppend = null;
    public $textAppendPage = null;

    //get global instance of resolver
    public static function instance()
    {
        return static::$instance ?? (static::$instance = new CatalogResolverService());
    }

    //resolve request chain and run specified controller method
    public function resolve(CatalogController $controller, $chain)
    {
        $chain = $chain ?? [];

        //prevent long chains
        if (count($chain) > 3) {
            return abort(404);
        }

        //First: try to find product
        if (count($chain ?? []) == 1 && ($product = Product::where("slug", $chain[0])->first())) {
            return $controller->product($product);
        }

        //Second: try to find set
        if (count($chain ?? []) == 1 && ($set = Set::where("slug", $chain[0])->first())) {
            return $controller->set($set);
        }

        //Third: parse chain
        $query = Product::where("products.status",1);
        $filters = [];
        foreach ($chain as $alias) {
            $filter = Filter::where("alias", $alias)
                ->first();
            if (!$filter || !$filter->group->chained) {
                return abort(404);
            }
            $filters[] = $filter;
        }

        $products = filters(count($filters) ? new Collection($filters) : null)->handle($query);
        //$products = $this->order($products);
        $this->paginate();
        return $controller->show($products);
    }

    //order products collection;
/*    public function order(Collection $products)
    {
        $ordering = request()->get("order");
        switch ($ordering) {
            case "discount_desc":
                $products = $products->sortBy("price")->sortByDesc("discount_percent");
                break;
            case "price_asc":
                $products = $products->sortBy("price");
                break;
            case "price_desc":
                $products = $products->sortByDesc("price");
                break;
            case "name_asc":
                $products = $products->sortBy("name");
                break;
            case "name_desc":
                $products = $products->sortByDesc("name");
                break;
            default:
                $products = $products->sortBy("order");
        }
        return $products;
    }*/

    //make pagination
    private function paginate()
    {
        $page = request()->get("page", 1);
        if ($page == "all") {
            $this->textAppendPage = "— все";
        }
        if ($page > 1) {
            $this->textAppendPage = "— страница {$page}";
        }
    }

    //get url for browser
    public function currentUrl()
    {
        $parts = $this->_baseUrlParts($chain = $this->chain());
        if (count($parts)) {
            return "/catalog/" . $chain . "?" . http_build_query($parts);
        }
        return "/catalog/" . $chain;
    }

    //get url for pagination links
    public function pageUrl($page)
    {
        $parts = $this->_baseUrlParts($chain = $this->chain());
        if ($page == 1) {
            unset($parts['page']);
        }
        if ($page != 1) {
            $parts['page'] = $page;
        }
        if (count($parts)) {
            return "/catalog/" . $chain . "?" . http_build_query($parts);
        }
        return "/catalog/" . $chain;
    }

    //generate array for url builder
    private function _baseUrlParts($chain = null)
    {
        $parts = request()->all();
        if ($chain) {
            unset($parts['filters']);
        }
        return $parts;
    }

    //generate url if filters chained
    //generates text for %chain% variable
    public function chain()
    {
        if ($this->chain) {
            return $this->chain;
        }

        $filters = filters()->filters;
        $count = count($filters);

        if ($count > 3 || $count < 1) {
            return null;
        }

        if (
            ($filters->where("group.chained", 1)->count() == $count) && //All groups chained
            ($filters->pluck("filter_group_id")->unique()->count() == $count) //Separated groups
        ) {
            foreach ($filters->sortBy("order")->sortBy("group.order") as $filter) {
                //Generate text for %chain%
                $this->textAppend .= $filter->chain_append . " ";
                //Generate URI segment
                $this->chain .= $filter->alias . "/";
            }
            return $this->chain;
        }
        return null;
    }


    //======================================= SITE MAP BUILDER ==============================================//

    function map()
    {
        $map = [];

        //---------------------- for 1 -----------------------------
        $groups = FilterGroup::with(['filters'])->orderBy("order")->where("chained", 1)->get();
        foreach ($groups as $group) {
            $this->_mapFor($map, $group);
        }

        //--------------------------- for 2 -------------------------------
        $groups1 = FilterGroup::with(['filters'])->orderBy("order")->where("chained", 1)->get();
        foreach ($groups as $group1) {
            $groups2 = FilterGroup::with(['filters'])->orderBy("order")->where("order", ">", $group1->order)->where("chained", 1)->get();
            foreach ($groups2 as $group2) {
                $this->_mapFor($map, $group1, $group2);
            }

        }

        //--------------------------- for 3 -------------------------------
        $groups1 = FilterGroup::with(['filters'])->orderBy("order")->where("chained", 1)->get();
        foreach ($groups as $group1) {
            $groups2 = FilterGroup::with(['filters'])->orderBy("order")->where("order", ">", $group1->order)->where("chained", 1)->get();
            foreach ($groups2 as $group2) {
                $groups3 = FilterGroup::with(['filters'])->orderBy("order")->where("order", ">", $group2->order)->where("chained", 1)->get();
                foreach ($groups3 as $group3) {
                    $this->_mapFor($map, $group1, $group2, $group3);
                }
            }

        }

        return $map;
    }

    private function _mapFor(&$map, $group1, $group2 = null, $group3 = null)
    {
        //-------------------- for 1 ---------------------
        if (!$group2) {
            foreach ($group1->filters as $filter) {
                if ($count = $this->_check(new Collection([$filter]))) {
                    $map[] = (object)[
                        'name' => $filter->chain_append,
                        'href' => "/catalog/" . $filter->alias,
                        'postfix' => ($count > cv("paginate")) ? "?page=all" : null,
                    ];
                }

            }
            return $map;
        }
        //---------------------- for 2 ---------------------------
        if (!$group3) {
            foreach ($group1->filters as $filter1) {
                foreach ($group2->filters as $filter2) {
                    if ($count = $this->_check(new Collection([$filter1, $filter2]))) {
                        $map[] = (object)[
                            'name' => $filter1->chain_append . " " . $filter2->chain_append,
                            'href' => "/catalog/" . $filter1->alias . "/" . $filter2->alias,
                            'postfix' => ($count > cv("paginate")) ? "?page=all" : null,
                        ];
                    }

                }
            }
            return $map;
        }

        //---------------------- for 3 ---------------------------

        foreach ($group1->filters as $filter1) {
            foreach ($group2->filters as $filter2) {
                foreach ($group3->filters as $filter3) {
                    if ($count = $this->_check(new Collection([$filter1, $filter2, $filter3]))) {
                        $map[] = (object)[
                            'name' => $filter1->chain_append . " " . $filter2->chain_append . " " . $filter3->chain_append,
                            'href' => "/catalog/" . $filter1->alias . "/" . $filter2->alias . "/" . $filter3->alias,
                            'postfix' => ($count > cv("paginate")) ? "?page=all" : null,
                        ];
                    }

                }

            }
        }
        return $map;
    }

    private function _check(Collection $filters)
    {
        $query = Product::where("status", 1);
        foreach ($filters as $filter) {
            $query = $query->whereIn("id", $filter->products->pluck("id")->toArray());
        }
        return $query->count();
    }
}
