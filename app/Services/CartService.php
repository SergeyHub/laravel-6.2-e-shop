<?php


namespace App\Services;


use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    private $_counts = [];
    private $_products = [];
    private static $_instance = null;
    private $_total = 0;
    private $_count = 0;
    private $_count_total = 0;

    public static function instance()
    {
        return static::$_instance ?? static::$_instance = new CartService();
    }

    private function __construct()
    {
        $items = Session::get('cart', []);
        foreach ($items as $id => $count) {
            $product = Product::findOrFail($id);
            $this->_counts[$id] = $count;
            $this->_products[$id] = $product;
            $this->_count++;
            $this->_count_total += $count;
            $this->_total += $product->price * $count;
        }

    }

    public function set($product, $count)
    {
        if ($count) {
            $this->_counts[$product->id] = $count;
            $this->_products[$product->id] = $product;
        } else {
            unset($this->_counts[$product->id]);
            unset($this->_products[$product->id]);
        }

        return $this;
    }

    private function _products()
    {
        $res = [];
        foreach ($this->_counts as $id => $count) {
            $product = $this->_products[$id];
            $res[] = (object)[
                "id" => $product->id,
                "count" => $count,
                "name" => $product->name,
                "url" => $product->getUrl(),
                "image" => $product->getImage(),
                "price" => $this->getPriceFor($product),
                "price_old" => $this->getOldPriceFor($product),
                "price_real" => $product->price
            ];
        }
        return $res;
    }

    public function commit()
    {
        $res = [];
        foreach ($this->_counts as $id => $count) {
            $res[$id] = $count;
        }
        Session::put('cart', $res);
        return $this;
    }

    public function flush()
    {
        Session::put('cart', []);
        return $this->reload();
    }

    public function reload()
    {
        return static::$_instance = new CartService();
    }

    public function getPriceFor($product)
    {
        if (!promocode()) {
            return $product->price * $this->_counts[$product->id];
        }
        return promocode()->calc(
                $product,
                $this->_counts[$product->id],
                $this->_count,
                $this->_count_total,
                $this->_total
            ) * $this->_counts[$product->id];
    }

    private function getOldPriceFor($product)
    {
        if (promocode() && promocode()->calc(
                $product,
                $this->_counts[$product->id],
                $this->_count,
                $this->_count_total,
                $this->_total
            ) < $product->price) {
            return $product->price * $this->_counts[$product->id];
        }
        if ($product->discount) {
            return $product->price_old * $this->_counts[$product->id];
        } else {
            return $product->price * $this->_counts[$product->id];
        }

    }

    private function total()
    {
        $total = 0;
        foreach ($this->_products as $product) {
            $total += $this->getPriceFor($product);
        }
        return $total;
    }

    private function totalOld()
    {
        $total_old = 0;
        foreach ($this->_counts as $id => $count) {
            $product = $this->_products[$id];
            $total_old += $this->getOldPriceFor($product) ?? $product->price_old ?? $product->price;
        }
        return $total_old;
    }

    public function __get($name)
    {
        switch ($name) {
            case "products":
                return $this->_products();
                break;
            case "collection":
                return new Collection($this->_products);
            case "count":
                return $this->_count;
                break;
            case "count_total":
                return $this->_count_total;
                break;
            case "total":
                return $this->total();
                break;
            case "total_old":
                return $this->totalOld();
                break;
            case "total_real":
                return $this->_total;
                break;
            case "empty":
                return $this->_count == 0;
                break;
            default:
                return null;
        }
    }

}
