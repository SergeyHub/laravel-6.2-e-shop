<?php


namespace App\Services;

/*
 * Filter product query and generate params for controls
 *
 * SHARED COMPONENT! EDIT ONLY IF YOU PLANED GLOBAL UPDATE!
 */

use App\Models\Filter;
use App\Models\FilterGroup;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class ProductFilteringService
{
    private static $instance = null;
    private $query = null;
    public $filters = null;
    private $products = null;
    private $pagination_count = 1;
    private $controls = null;
    public $count = 0;
    public $price_min = null;
    public $price_max = null;

    //get global instance of filtering service
    public static function instance($filters = null)
    {
        return static::$instance ?? (static::$instance = new ProductFilteringService($filters));
    }

    //if filters specified - use prepared models, if not - use request for find filters;
    public function __construct($filters = null)
    {
        $this->filters = $filters ?? Filter::whereIn("alias", request()->get("filters", []))->get();
    }

    /**
     * Handle query and return list of products
     *
     * @param Builder $query
     * @return Collection
     */
    public function handle(Builder $query)
    {
        //building summary query
        $this->query = $query
            ->leftJoin("product_prices as prices", function ($query) {
                $query
                    ->on("products.id", "=", "prices.product_id")
                    ->where("prices.country_id", 1)
                    ->where("prices.qty", 1);
            })
            ->leftJoin("product_prices as prices_old", function ($query) {
                $query
                    ->on("products.id", "=", "prices_old.product_id")
                    ->where("prices_old.country_id", 1)
                    ->where("prices_old.qty", 0);
            })
            ->select("products.*");

        //query filters
        $query = $this->filterChain();
        $this->count = $query->count();
        //get products
        $this->products = $this->_prepare($query)->get();

        return $this->products;
    }

    //Default filters chain
    function filterChain($override = [])
    {
        $override = (object)$override;
        $query = clone($override->query ?? $this->query);

        $query = $this->_filter($query, $override->filters ?? $this->filters);
        $query = $this->_availability($query, $override->availability ?? request()->get("availability", 0));
        $query = $this->_latest($query, $override->latest ?? request()->get("latest", 0));
        $query = $this->_promote($query, $override->promote ?? request()->get("promote", 0));
        $query = $this->_discount($query, $override->discount ?? request()->get("discount", 0));
        $query = $this->_price($query);

        return $query;
    }

    //Unused
    public function uri()
    {
        return request()->fullUrl();
    }

    //Generate params tree for building catalog controls
    public function controls()
    {
        if ($this->controls) {
            return $this->controls;
        }

        if (!$this->query) {
            throw new \RuntimeException("Attempting to build filter tree without handling query!");
        }

        //------ fill price filter -------//
        $controls = [
            "price_from" => request("price_from", $this->price_min) ?? 0,
            "price_min" => $this->price_min ?? 0,
            "price_to" => request("price_to", $this->price_max) ?? 0,
            "price_max" => $this->price_max ?? 0,
        ];

        //---- fill availability filter ----//
        $controls['availability'] = request()->get("availability", 0);
        $controls['availability_count'] = $this->filterChain(['availability' => 1])->count();

        //---- fill promote filter ----//
        $controls['promote'] = request()->get("promote", 0);
        $controls['promote_count'] = $this->filterChain(['promote' => 1])->count();

        //---- fill new filter ----//
        $controls['latest'] = request()->get("latest", 0);
        $controls['latest_count'] = $this->filterChain(['latest' => 1])->count();

        //---- fill discount filter ----//

        $count = $this->products->filter(function ($product) {
            return $product->discount;
        })->count();
        $controls['discount'] = request()->get("discount", 0);
        $controls['discount_count'] = $count;

        //---- fill filter groups ----//
        $groups = [];
        foreach (FilterGroup::with(['filters'])->orderBy("order")->get() as $filterGroup) {
            $group = [
                'name' => $filterGroup->display_name ?? $filterGroup->name,
                'alias' => $filterGroup->alias,
                'filters' => []
            ];
            $active = false;
            foreach ($filterGroup->filters as $filter) {

                //-------------- counters logic -------------

                if (!$this->filters->contains($filter->id)) {
                    $count = $this->filterChain(["filters" => (clone $this->filters)->push($filter)])->whereHas("filters", function ($q) use ($filter) {
                        $q->where("filters.id", $filter->id);
                    })->count();
                } else {
                    $count = $this->filterChain()->whereHas("filters", function ($q) use ($filter) {
                        $q->where("filters.id", $filter->id);
                    })->count();
                }

                //--------------------------------------------

                $instance = [
                    "name" => $filter->name,
                    "alias" => $filter->alias,
                    "checked" => $this->filters->contains($filter->id),
                    "count" => $count,
                ];
                if ($instance['checked']) {
                    $active = true;
                }
                $group['filters'][$filter->alias] = (object)$instance;
            }
            $group['active'] = $active;
            if (count($group['filters'])) {
                $groups[$filterGroup->alias] = (object)$group;
            }

        }
        $controls['groups'] = $groups;

        //----- fill pagination settings ------//

        $controls['paginate'] = !(request("page") == "all");
        $controls['pagination_count'] = (int)ceil($this->filterChain()->count() / cv("paginate"));
        $controls['pagination_current'] = request()->get("page", 1);

        //---------- filters active -------------//

        $controls['filters_active'] = (
            request()->get("availability", 0) ||
            request()->get("promote", 0) ||
            request()->get("latest", 0) ||
            request()->get("discount", 0) ||
            count($this->filters) ||
            request("price_from", $this->price_min) != $this->price_min ||
            request("price_to", $this->price_max) != $this->price_max
        );

        $controls['view'] = request("view", "grid");
        $controls['order'] = request("order", "popular");
        //------------------------------//


        $this->controls = (object)$controls;
        //dd($this->tree);
        return $this->controls;
    }

    //filter in price range. Generating min and max price for tree
    /*    private function _price(Collection $products)
        {
            $products = clone $products;

            //handle range
            if ($price_from = request()->get("price_from")) {
                $products = $products->filter(function ($model) use ($price_from) {
                    return $model->price >= $price_from;
                });
            }
            if ($price_to = request()->get("price_to")) {
                $products = $products->filter(function ($model) use ($price_to) {
                    return $model->price <= $price_to;
                });
            }
            return $products;
        }*/

    private function _price($query)
    {
        //calculate min/max prices
        if (is_null($this->price_min) || is_null($this->price_max)) {
            $this->price_min = ($query->min("prices.price") * country()->rate) ?? 0;
            $this->price_max = ($query->max("prices.price") * country()->rate) ?? 0;
        }
        //handle range
        if ($price_from = request()->get("price_from")) {
            $query->where(function ($q) use ($price_from) {
                $q->where("prices.price", ">=", $price_from / country()->rate);
            });
        }
        if ($price_to = request()->get("price_to")) {
            $query->where(function ($q) use ($price_to) {
                $q->where("prices.price", "<=", $price_to / country()->rate);
            });
        }
        return $query;
    }

    //filter by Filter model
    private function _filter($query, Collection $filters)
    {
        //3.0
        $groups = $filters->pluck("group")->flatten()->unique();
        foreach ($groups as $group) {
            $query = $query->whereHas("filters", function ($q) use ($filters, $group) {
                $ids = $filters->where("filter_group_id", $group->id)->pluck("id")->toArray();
                $q->whereIn("filters.id", $ids);
            });
        }
        return $query;
    }

    //filter by Availability (under_order)
    private function _availability($query, $mode)
    {
        if ($mode) {
            $query = $query
                ->where("under_order", "<", "1");
        }
        return $query;
    }

    //filter by Promote
    private function _promote($query, $mode)
    {
        if ($mode) {
            $query = $query
                ->where("bestseller", "1");
        }
        return $query;
    }

    //filter by New
    private function _latest($query, $mode)
    {
        if ($mode) {
            $query = $query
                ->where("new", "1");
        }
        return $query;
    }

    //filter by discount
    private function _discount($query, $mode)
    {
        if ($mode) {
            $query->where(function ($q) {
                $q->where("prices_old.price", ">", 0);
            });
        }
        return $query;
    }

    //paging and ordering
    private function _prepare($query)
    {
        //ordering
        $ordering = request()->get("order");
        switch ($ordering) {
            case "price_asc":
                $query->orderBy("prices.price", "asc");
                break;
            case "price_desc":
                $query->orderBy("prices.price", "desc");
                break;
            case "name_asc":
                $query->orderBy("products.name", "asc");
                break;
            case "name_desc":
                $query->orderBy("products.name", "desc");
                break;
            default:
                $query->orderBy("products.order", "asc");
        }

        //pagination
        $page = request()->get("page", 1);
        if ($page == "all") {
            return $query;
        }
        if ($page > 1) {
            return $query->skip(cv("paginate") * ($page - 1))->take(cv("paginate"));
        }
        return $query->take(cv("paginate"));
    }
}
