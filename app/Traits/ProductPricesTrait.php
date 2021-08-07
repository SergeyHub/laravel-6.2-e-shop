<?php


namespace App\Traits;


use App\Models\Country;
use App\Services\RepositoryService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait ProductPricesTrait
{
    /**
     * Set price
     *
     * @param $value
     * @param int $qty
     * @param null $country_id
     */
    public function setPrice($value, $qty = 1, $country_id = null)
    {
        if (!$country_id) {
            $country_id = country()->id;
        }
        if ($this->id) {
            DB::table("product_prices")->updateOrInsert(['product_id' => $this->id, 'qty' => $qty, 'country_id' => $country_id], ['price' => $value]);
        }
    }

    /**
     * Get price
     *
     * @param int $qty
     * @param null $country_id
     * @param false $force_real
     * @return float|int|mixed
     */
    public function getPrice($qty = 1, $country_id = null, $force_real = false)
    {

        //Страна не задана, берём текущую страну
        if (!$country_id) {
            $country_id = country()->id;
        }

        //ключ кэша
        $cache_key = "price_{$this->id}_{$qty}_{$country_id}";

        //проверка попадания в кэш
        if(!$force_real && Cache::has($cache_key))
        {
            return Cache::get($cache_key);
        }

        //время кэша
        $time = env("PRICE_CACHE",1000) + rand(0,200);

        //модель создана
        if ($this->id) {
            $price_ent = DB::table("product_prices")->where(['product_id' => $this->id, 'qty' => $qty, 'country_id' => $country_id])->first();
            //$price_ent = RepositoryService::prices()->where('product_id',$this->id)->where('qty', $qty)->where('country_id', $country_id)->first();
            //цена за единицу указана
            if ($price_ent && $price_ent->price > 0)
            {
                //возвращаем цену
                Cache::put($cache_key,$price = $price_ent->price, $time);
                return $price;
            }
            //цена не указана или 0, для цен за 1+ едениц товара и не запрошено реальное значение
            if ($qty != 0 && !$force_real)
            {
                $country = RepositoryService::countries()->where("id",$country_id)->first();
                //ищем цену в России
                $price_ent = DB::table("product_prices")->where(['product_id' => $this->id, 'qty' => $qty])->orderBy('country_id')->first();
                //$price_ent = RepositoryService::prices()->where('product_id',$this->id)->where('qty', $qty)->sortBy('country_id')->first();
                //если нашли
                if ($price_ent && $price_ent->price > 0)
                {
                    Cache::put($cache_key,$price = $price_ent->price * $country->rate, $time);
                    return $price;
                }
                //не нашли, возвращаем цену за единицу*количество
                if ($qty > 1)
                {
                    Cache::put($cache_key,$price = $this->getPrice(1,$country_id)*$qty, $time);
                    return $price;
                }
            }
        }
        //возвращаем цену
        Cache::put($cache_key,$price = 0, $time);
        return $price;
    }

    /**
     * List of all prices
     *
     * @return mixed
     */
    public function prices()
    {
        return $this->hasMany('App\Models\ProductPrice')->orderBy("qty","ASC");
    }

    /**
     * List of prices for 1 piece
     *
     * @return mixed
     */

    public function pricesOne()
    {
        return $this->hasMany('App\Models\ProductPrice')->where('qty', 1)->orderBy('country_id');
    }

    /**
     * List of OLD prices for 1 piece
     *
     * @return mixed
     */
    public function pricesOld()
    {
        return $this->hasMany('App\Models\ProductPrice')->where('qty', 0)->orderBy('country_id');
    }

    /* Оптовые цены */
    public function getPrices()
    {
        $prices = $this->prices->where('country_id', country()->id)->pluck('price', 'qty')->toArray();
        return json_encode($prices);
    }

    /**
     * Check for product is discount;
     *
     * @return bool
     */
    function isDiscount()
    {
        return $this->price_old > 0 && $this->price < $this->price_old;
    }

    /**
     * Get discount percent value
     *
     * @param $key
     * @return float|int
     */
    function discountPercent()
    {
        return $this->isDiscount() ? round(($this->price_old - $this->price) / $this->price_old * 100) : 0;
    }

    /**
     * Get discount number value
     *
     * @param $key
     * @return int
     */
    function discountValue()
    {
        return $this->isDiscount() ? ($this->price_old - $this->price) : 0;
    }

    //===================== GETTERS ======================//
    /**
     * Getter for $this->price
     *
     * @return float|int|mixed
     */
    public function GetPriceAttribute()
    {
        return $this->getPrice();
    }

    /**
     * Getter for $this->old_price
     *
     * @return float|int|mixed
     */
    public function GetOldPriceAttribute()
    {
        return $this->getPrice(0);
    }

    /**
     * Getter for $this->price_old
     *
     * @return float|int|mixed
     */
    public function GetPriceOldAttribute()
    {
        return $this->getPrice(0);
    }

    /**
     * Getter for $this->discount
     *
     * @return int
     */
    public function GetDiscountAttribute()
    {
        return $this->discountValue();
    }

    /**
     * Getter for $this->discount_percent
     *
     * @return float|int
     */
    public function GetDiscountPercentAttribute()
    {
        return $this->discountPercent();
    }

    /**
     * Getter for $this->discount_value
     *
     * @return int
     */
    public function GetDiscountValueAttribute()
    {
        return $this->discountValue();
    }
}
