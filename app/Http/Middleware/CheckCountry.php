<?php

namespace App\Http\Middleware;

use Closure;


class CheckCountry
{
    
    public function handle($request, Closure $next)
    {
        
        $country = country();
        if (!$country->status) {
            abort(403);
        }
        
        $response = $next($request);
        return $response;
    }
}