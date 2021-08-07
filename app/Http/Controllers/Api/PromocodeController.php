<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PromocodeService;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{
    function apply(Request $request)
    {
        if ($code = $request->get("code")) {

            if (PromocodeService::check(mb_strtoupper($code))) {
                return [
                    "fields" => [
                        '.js-cart-content' => view("pages.cart.cart-content")->render(),
                    ]
                ];
            }
        }

        return [
            "fields" => [
                ".js-promocode" => view("pages.cart.promocode")->render(),
                '.js-promocode-error' => "Промокод неверен или истёк"
            ]
        ];
    }

    function remove(Request $request)
    {
        if (promocode()) {
            promocode()->remove();
        }
        return [
            "fields" => [
                '.js-cart-content' => view("pages.cart.cart-content")->render(),
            ]
        ];
    }
}
