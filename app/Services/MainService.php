<?php

namespace App\Services;

use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumn;
use Illuminate\Support\Str;
use App\Models\{CorrectItem, Product, ProductPrice, Category, Page, City, Country};

class MainService
{
    private static $variables = null;
    private static $variables_user = null;
    private static $city = null;
    private static $country = null;


    public static function countries()
    {
        static $countries = null;
        if (\is_null($countries)) {
            $countries = Country::with('corrects.correct')->whereStatus(1)->get();
        }
        return $countries;
    }
    public static function cities()
    {
        static $cities = null;
        if (\is_null($cities)) {
            $cities = City::where('country_id',country()->id)->get();
        }
        return $cities;
    }
    public static function pages()
    {
        static $pages = null;
        if (\is_null($pages)) {
            $pages = Page::whereStatus(1)->get();
        }
        return $pages;
    }
    public static function categories()
    {
        static $categories = null;
        if (\is_null($categories)) {
            $categories = Category::with('products.prices')
                            ->whereStatus(1)
                            ->where('country_id',country()->id)
                            ->orderBy('order')
                            ->get();
        }
        return $categories;
    }
    public static function products()
    {
        static $products = null;
        if (\is_null($products)) {
            $products = Product::with('prices','categories')->whereStatus(1)->orderBy('order')->get();
        }
        return $products;
    }

    /**
     * Return system variables for replaceVariable() helper
     *
     * @return array
     */
    public static function getSystemTextVariables()
    {
        if (is_null(static::$variables)) {

            $pids = Product::where("status",1)->get()->pluck('id')->toArray();

            $minPrice = \App\Models\ProductPrice::whereIn('product_id',$pids)->where('qty',1)->min('price');

            //$minPriceYoung =        \App\Models\ProductPrice::whereIn('product_id', DB::table("product_types")->where("type_id",1)->whereIn("product_id",$pids)->get()->pluck('product_id')->toArray())->where('qty', 1)->min('price');
            //$minPriceAdult =        \App\Models\ProductPrice::whereIn('product_id', DB::table("product_types")->where("type_id",2)->whereIn("product_id",$pids)->get()->pluck('product_id')->toArray())->where('qty', 1)->min('price');
            //$minPriceAccessory =    \App\Models\ProductPrice::whereIn('product_id', DB::table("product_types")->where("type_id",3)->whereIn("product_id",$pids)->get()->pluck('product_id')->toArray())->where('qty', 1)->min('price');

            static::$variables = [
                '%phone%'=>getPhone()['format'],
                '%phone1%'=>getPhone()['format'],
                '%phone2%'=>getPhone2()['format'],
                '%address%'=>getAddress(),
                '%schedule%'=>getSchedule(),
                '%domain%'=>$_SERVER['HTTP_HOST'],
                '%min_price%' => $minPrice,
                //'%min_price_accessory%' => $minPriceAccessory,
                //'%min_price_adult%' => $minPriceAdult,
                //'%min_price_young%' => $minPriceYoung,
            ];
        }
        return static::$variables;
    }

    /**
     * Return user defined variables for replaceVariable() helper
     *
     * @return array
     */
    public static function getUserDefinedTextVariables()
    {
        if (is_null(static::$variables_user)) {
            $items = CorrectItem::where("country_id",static::getCurrentCountry()->id)->get();
            static::$variables_user = [];
            foreach ($items as $item)
            {
                static::$variables_user['%'.$item->correct->key.'%'] = $item->text;
            }
        }
        return static::$variables_user;
    }

    /**
     * Returns current city instance
     *
     * @return City | null
     */
    public static function getCurrentCity()
    {
        if (!static::$city)
        {
            static $city = false;
            $country = static::getCurrentCountry();
            if ($city === false) {
                if ($_SERVER['HTTP_HOST'] != $country->domain) {
                    $sub = explode('.', $_SERVER['HTTP_HOST']);
                    $sub = array_shift($sub);
                    $city= \App\Models\City::where('country_id',$country->id)->where('slug',$sub)->first();
                    if (!$city) {
                        abort(404);
                    }
                } else {
                    $sCity = request()->session()->get('Scity');
                    $city = null;
                    if ($sCity === null) {
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip . '?lang=ru'));
                        if ($query && $query['status'] == 'success') {

                            $name = $query['city'];
                            $city = \App\Models\City::where('country_id',$country->id)->where('name',$name)->first();

                            if ($city) {
                                session(['Scity' => $city->id]);
                            } else {
                                session(['Scity' => 0]);
                            }
                        } else {
                            session(['Scity' => 0]);
                        }
                    } else {
                        //$sCity = session(['city'=> $sCity]);
                        $city = \App\Models\City::find($sCity);
                    }
                }
                if (!$city && $country->id == 2) {
                    $city = \App\Models\City::find(188);
                }
                if (!$city && $country->id == 1) {
                    $city = \App\Models\City::find(10);
                }
            }
            static::$city = $city;
        }
        return static::$city;
    }

    /**
     * Returns current country instance
     *
     * @return Country | null
     */
    public static function getCurrentCountry()
    {
        if (!static::$country)
        {
            static $country = false;
            if ($country === false) {
                preg_match("/([\w\-]+?)\.([\w\-]+?)$/",$_SERVER['HTTP_HOST'],$matches);
                if (isset($matches[0])) {
                    $domain = $matches[0];
                    $country = \App\Models\Country::where('domain',$domain)->first();
                }
                $country = $country ?? \App\Models\Country::first();
            }
            static::$country = $country;
        }
        return static::$country;
    }
    public static function catalogOrders()
    {

        return [
            'popular' => [
                'label' => 'По популярности',
                'icon'  => 'decrease',
            ],
            'price_asc' => [
                'label' => 'По цене',
                'icon'  => 'increase',
            ],
            'price_desc' => [
                'label' => 'По цене',
                'icon'  => 'decrease',
            ],
            'name_asc' => [
                'label' => 'По названию',
                'icon'  => 'increase',
            ],
            'name_desc' => [
                'label' => 'По названию',
                'icon'  => 'decrease',
            ],
           /* 'discount_desc' => [
                'label' => 'По размеру скидки',
                'icon'  => 'decrease',
            ],*/
        ];
    }
}
