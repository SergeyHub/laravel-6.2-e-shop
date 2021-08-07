<?php


namespace App\Services;


use App\Services\API\LibraryConnector;
use Illuminate\Support\Facades\Session;

class PromocodeService
{
    static $_instance;

    public $status = null;
    public $code = null;

    private $type = null;
    private $value = null;

    private $overrides = [];

    private $products_included = null;
    private $products_excluded = null;

    private $min_cart_total = 0;
    private $min_product_total = 0;
    private $min_product_price = 0;
    private $min_cart_count = 0;
    private $min_cart_count_total = 0;
    private $min_product_count = 0;


    public static function instance()
    {
        if(Session::has("promocode"))
        {
            return static::$_instance ?? static::$_instance = new PromocodeService(Session::get("promocode"));
        }
        return null;
    }

    private function __construct($promocode)
    {
        foreach ($promocode as $param_name=>$param_value)
        {
            $this->$param_name = $param_value;
        }
        //
        $this->overrides = (array)$this->overrides;

        //calc rates

        $this->min_cart_total = (int)ceil($this->min_cart_total*country()->rate);
        $this->min_product_total = (int)ceil($this->min_product_total*country()->rate);
        $this->min_product_price = (int)ceil($this->min_product_price*country()->rate);
        if($this->type == 2)
        {
            (int)ceil($this->value =  $this->value*country()->rate);
        }

        static::$_instance = $this;
    }

    public function calc($product, $product_count, $cart_count, $cart_count_total, $cart_total)
    {
        //check included
        if(count($this->products_included) && !in_array($product->remote_id, $this->products_included))
        {
            return $product->price;
        }

        //check excluded
        if(count($this->products_excluded) && in_array($product->remote_id, $this->products_excluded))
        {
            return $product->price;
        }

        //check cart total
        if($this->min_cart_total && $this->min_cart_total > $cart_total)
        {
            return $product->price;
        }

        //check product total
        if($this->min_product_total && $this->min_product_total > ($product->price*$product_count))
        {
            return $product->price;
        }

        //check product price
        if($this->min_product_price && $this->min_product_price > $product->price)
        {
            return $product->price;
        }

        //check cart count
        if($this->min_cart_count && $this->min_cart_count > $cart_count)
        {
            return $product->price;
        }

        //check product count
        if($this->min_product_count && $this->min_product_count > $product_count)
        {
            return $product->price;
        }

        //check cart count total
        if($this->min_product_count && $this->min_product_count > $product_count)
        {
            return $product->price;
        }

        //check product count for Promocode Type #2
        if($this->type == 2 && $this->value > $product_count)
        {
            return $product->price;
        }

        $remote_id  = $product->remote_id;
        $value = $this->overrides[$remote_id] ?? $this->value;

        switch ($this->type)
        {
            case 0:
                return (int) ceil(($product->price / 100) * (100 - $value));
                break;
            case 1:
                return $product->price - ($value * country()->rate);
                break;
            case 2:
                if($product_count >= $value)
                {
                    return (int) ceil(($product->price / $product_count) * ($product_count - 1));
                }
                return $product->price;
                break;
            default:
                return  $product->price;
        }
    }

    public static function check($code)
    {
        $library = new LibraryConnector();
        $res = $library->promocodeCheck($code);
        if($res)
        {
            Session::put("promocode", $res);
            return true;
        }
        return false;
    }

    public function remove()
    {
        Session::remove("promocode");
    }

    public function apply($products)
    {
        $library = new LibraryConnector();
        return $library->promocodeApply($this->code, $products->pluck("remote_id")->toArray());
    }

}
