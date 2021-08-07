<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class RepositoryService
{
    private static $_prices = null;
    private static $_countries = null;

    public static function prices(){
        if (!static::$_prices)
        {
            static::$_prices = DB::table("product_prices")->get();
        }
        return static::$_prices;
    }

    public static function countries(){
        if (!static::$_countries)
        {
            static::$_countries = DB::table("countries")->get();
        }
        return static::$_countries;
    }
}
