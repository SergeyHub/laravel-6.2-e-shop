<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);
/* Route::any('register', function () {
    abort(404);
}); */

Route::group(['prefix' => '/actions'], function () {
    Route::any('/update/price', 'AdminController@remoteUpdatePrice')->name('catalog.update');
    Route::any('/reviews/add', 'ReviewController@store')->name('reviews.add');
    Route::any('/questions/add', 'QuestionController@store')->name('questions.add');
    Route::post('/comments/add', 'ArticleController@storeComment')->name('comments.add');

});
Route::get('/answers/{hash}', 'QuestionController@showMail')->name('answer');

Route::group(['middleware' => 'country'], function () {
    Route::get('/', 'PageController@showFront')->name('front');
    Route::get('/test', 'PageController@test')->name('test');
    Route::get('robots.txt', 'PageController@robots')->name('robots');
    Route::get('/sitemap.xml', 'PageController@sitemap')->name('sitemap');
    Route::get('/sitemap', 'PageController@pageSitemap')->name('page.sitemap');
    Route::get('/success', 'OrderController@success')->name('success');
    Route::get('/thankyou', 'CallbackController@success')->name('callback.success');

    Route::any('/quick', 'OrderController@quick')->name('quick');

    Route::group(['prefix' => '/blog'], function () {
      Route::get('/', 'ArticleController@blogIndex')->name('blog.index');
      Route::get('/{slug}', 'ArticleController@blogShow')->name('blog.show');
    });
    Route::group(['prefix' => '/news'], function () {
      Route::get('/', 'ArticleController@newsIndex')->name('news.index');
      Route::get('/{slug}', 'ArticleController@newsShow')->name('news.show');
    });
    Route::group(['prefix' => '/promo'], function () {
      Route::get('/', 'ArticleController@promoIndex')->name('promo.index');
      Route::get('/{slug}', 'ArticleController@promoShow')->name('promo.show');
    });
    Route::group(['prefix' => '/catalog'], function () {
        //Route::any('/get', 'CatalogController@index')->name('catalog.get');
        //Route::get('/', 'CatalogController@resolver')->name('catalog.show');
        Route::any('/{slugs?}/', 'CatalogController@resolver')->where('slugs','.*')->name('catalog.show');
        //Route::get('/{slug}', 'CatalogController@resolver')->name('catalog.category');
        //Route::get('/{category_slug}/{slug}', 'CatalogController@productFind')->name('catalog.product');
    });
    Route::group(['prefix' => '/callback'], function () {
        Route::post('/store', 'CallbackController@store')->name('callback.set');
        Route::post('/qty','CallbackController@quantity')->name('callback.qty');
        Route::post('/price', 'CallbackController@price')->name('callback.price');
        //
        Route::post('/set/contacts', 'CallbackController@storeWithCaptcha')->name('callback.set.captcha');
    });
    Route::group(['prefix' => '/cart'], function () {
        Route::get('/', 'OrderController@show')->name('cart_show');
        Route::post('/set', 'OrderController@cartSet')->name('cart.set');
        Route::post('/order', 'OrderController@store')->name('order.set');
        Route::post('/quick', 'OrderController@storeQuick')->name('order.quick');
    });



    Route::get('/contacts', 'PageController@contacts')->name('contacts.show');


    Route::get('/market.xml', 'CatalogController@market')->name('catalog.market');



    Route::get('/{slug}', 'PageController@show')->where('slug', '(?!admin).*')->name('page.show');
    //Route::get('/home', 'HomeController@index')->name('home');

});
