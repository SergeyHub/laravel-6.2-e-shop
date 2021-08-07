<?php

namespace App\Http\Middleware;

use App\Models\History;
use Closure;
use Illuminate\Support\Facades\Event;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!access()->manager) {
            return redirect('/login');
        }

        //-------------------- HOOK MODEL EVENTS FOR LOGGING HANDLER --------------------
        Event::listen('eloquent.created: *', function ($event, $model) {
            History::ModelCreate($model);
        });
        Event::listen('eloquent.updating: *', function ($event, $model) {
            History::ModelUpdate($model);
        });
        Event::listen('eloquent.deleted: *', function ($event, $model) {
            History::ModelDelete($model);
        });

        return $next($request);
    }
}
