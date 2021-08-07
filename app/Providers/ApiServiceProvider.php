<?php

namespace App\Providers;

use App\Http\Middleware\CheckCRMToken;
use App\Interfaces\IEditable;
use App\Models\History;
use App\Models\Question;
use App\Services\AdminMessagesService;
use GuzzleHttp\Client;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*        Route::get("api/test",function(){
                    $token = config("crm.token");
                    $date = date('d.m.Y');
                    $time = date('H:i:s');


                    $test_data = [
                        "token" => md5($token . md5($time) . $date . md5($token)),
                        "date" => $date,
                        "time" => $time
                    ];

                    $client = new Client();
                    $response = $client->post('http://volgograd.poiskovik24.prom.localhost/api/sync/run/price ', ["form_params" => $test_data]);
                    return $response->getBody();
                });*/
        //Remote update call
        Route::post("api/sync/run/{content}", "App\Http\Controllers\Api\SyncController@postRunRemoteUpdate")->middleware(CheckCRMToken::class);
        //Remote CreateByRemote call
        Route::post("api/sync/add/{content}", "App\Http\Controllers\Api\SyncController@postRunRemoteAdd")->middleware(CheckCRMToken::class);
        //get site data for crm
        Route::get("api/sync/get/data", "App\Http\Controllers\Api\SyncController@getSiteData")->middleware(CheckCRMToken::class);
        //check TinyPNG status
        Route::get("api/status/tinypng", "App\Http\Controllers\Api\ImageController@getTinyPNGStatus")->name("api.status.tinypng")->middleware("web", "admin");

        //link relays
        Route::get("api/relay/{remote_id}/edit", "App\Http\Controllers\Api\SyncController@relayToEdit")->middleware(CheckCRMToken::class);
        Route::get("api/relay/{remote_id}/show", "App\Http\Controllers\Api\SyncController@relayToShow");

        //products sync
        Route::get("admin/products/library/download","App\Http\Controllers\Api\SyncController@updateProducts")->name("admin.products.download")->middleware("web", "admin");
        Route::get("admin/products/library/upload","App\Http\Controllers\Api\SyncController@sendProducts")->name("admin.products.upload")->middleware("web", "admin");

        //logout route with slash
        Route::any("logout/", "App\Http\Controllers\Auth\LoginController@logout")->middleware("web");

        //toggle dev mode
        Route::get('admin/devmode/{state}',"App\Http\Controllers\Api\DevController@toggleDevMode")->name("admin.devmode")->middleware("web", "admin");
        // toggle editor mode
        Route::get('admin/editmode/{state}',"App\Http\Controllers\Api\QuickActionsController@toggleEditMode")->name("admin.editmode")->middleware("web", "admin");

        //---------------------------- MODELS QUICK API -------------------------------//
        Route::post("admin/questions/{question}/quick", ['as' => 'admin.question.quick', 'uses' => 'App\Http\Controllers\Api\QuickActionsController@quickQuestionAnswer'])->middleware("web", "admin");
        Route::post("admin/reviews/{review}/quick", ['as' => 'admin.reviews.quick', 'uses' => 'App\Http\Controllers\Api\QuickActionsController@quickReviewStatus'])->middleware("web", "admin");
        Route::post("admin/comments/{comment}/quick", ['as' => 'admin.comments.quick', 'uses' => 'App\Http\Controllers\Api\QuickActionsController@quickCommentStatus'])->middleware("web", "admin");
        //update catalog orders and statuses
        Route::get("admin/catalog/update", ['as' => 'admin.catalog.update', 'uses' => 'App\Http\Controllers\Api\QuickActionsController@updateCatalog'])->middleware("web", "admin");
        //----------------------------------------------------------------------//
        //--------------------- META EDITOR -----------------------//
        Route::get("admin/editor/meta", "App\Http\Controllers\Api\MetaEditorController@getForm")->name("editor.meta")->middleware("web", "admin");
        Route::get("api/meta/data", "App\Http\Controllers\Api\MetaEditorController@getData")->name("editor.meta.data")->middleware("web", "admin");
        Route::post("api/meta/data", "App\Http\Controllers\Api\MetaEditorController@postData")->name("editor.meta.data")->middleware("web", "admin");
        //-------------------- HISTORY ------------------------------------
        Route::get("admin/history/{history}/show", "App\Http\Controllers\Api\HistoryController@show")->name("admin.history.show")->middleware("web", "admin");
        Route::get("admin/history/clean", "App\Http\Controllers\Api\HistoryController@clear")->name("admin.history.clear")->middleware("web", "admin");
        //---------------------- MAINTENANCE ------------------
        Route::get("admin/dev/clear/view", "App\Http\Controllers\Api\DevController@clearView")->name("admin.dev.clear.view")->middleware("web", "admin");
        Route::get("admin/dev/clear/cache", "App\Http\Controllers\Api\DevController@clearCache")->name("admin.dev.clear.cache")->middleware("web", "admin");
        Route::get("admin/dev/clear/route", "App\Http\Controllers\Api\DevController@clearRoute")->name("admin.dev.clear.route")->middleware("web", "admin");
        Route::get("admin/dev/clear/config", "App\Http\Controllers\Api\DevController@clearConfig")->name("admin.dev.clear.config")->middleware("web", "admin");
		Route::get("admin/dev/optimize", "App\Http\Controllers\Api\DevController@optimize")->name("admin.dev.optimize")->middleware("web", "admin");
        Route::get("admin/dev/db/migrate", "App\Http\Controllers\Api\DevController@migrate")->name("admin.dev.migrate")->middleware("web", "admin");
        Route::get("admin/dev/products/images/rename", "App\Http\Controllers\Api\ImageController@fixProductImages")->name("admin.dev.product.images.rename")->middleware("web", "admin");
        Route::get("admin/dev/products/images/optimize", "App\Http\Controllers\Api\ImageController@optimizeProductImages")->name("admin.dev.product.images.optimize")->middleware("web", "admin");
        Route::get("admin/dev/check/sitemap", "App\Http\Controllers\Api\DevController@checkSitemap")->name("admin.dev.check.sitemap")->middleware("web", "admin");

        //--------------------- PROMOCODE ----------------------
        Route::post("api/promocode/apply","App\Http\Controllers\Api\PromocodeController@apply")->name("promocode.apply")->middleware('web');
        Route::post("api/promocode/remove","App\Http\Controllers\Api\PromocodeController@remove")->name("promocode.remove")->middleware('web');

        //-------------------- ADMIN MESSAGES ----------------------
        AdminMessagesService::routes();

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
