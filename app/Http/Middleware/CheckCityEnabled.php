<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Request;

class CheckCityEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $country = country();
        $main_domain = $country->domain;
        if ($_SERVER['HTTP_HOST'] != $main_domain) {
            $sub = explode('.', $_SERVER['HTTP_HOST']);
            $sub = array_shift($sub);
            if (\App\Models\City::where('country_id', $country->id)->where('slug', $sub)->where('status', 1)->count() == 0) {
                if (\Request::route()->getName() == "front") {
                    return redirect((Request::secure() ? 'https://' : 'http://' ) . $main_domain);
                }
                return redirect((Request::secure() ? 'https://' : 'http://' ). $main_domain . "/" . $request->path());
            }
        }
        return $next($request);
    }
}
