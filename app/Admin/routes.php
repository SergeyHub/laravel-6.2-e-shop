<?php


Route::get('', ['as' => 'admin.dashboard', 'uses' => 'App\Http\Controllers\AdminController@index']);


Route::post('/save/image', ['as' => 'admin.save.image', 'uses' => 'App\Http\Controllers\AdminController@saveImage']);
Route::post('/save/fieldimage', ['as' => 'admin.save.fieldimage', 'uses' => 'App\Http\Controllers\AdminController@saveFieldImage']);
Route::get('cities/export', ['as' => 'admin.export', 'uses' => 'App\Http\Controllers\AdminController@contactsExport']);
Route::get('cities/import', ['as' => 'admin.importForm', 'uses' => 'App\Http\Controllers\AdminController@contactsImportForm']);
Route::post('cities/import', ['as' => 'admin.import', 'uses' => 'App\Http\Controllers\AdminController@contactsImport']);
Route::post('order', ['as' => 'admin.order', 'uses' => 'App\Http\Controllers\AdminController@changeOrder']);
Route::get('products/update', ['as' => 'admin.updatePrices', 'uses' => 'App\Http\Controllers\AdminController@updatePrices']);
Route::get('compress', ['as' => 'admin.compress', 'uses' => 'App\Http\Controllers\AdminController@compress']);
Route::get('/download/callback/{id}/{file}', ['as' => 'admin.download', 'uses' => 'App\Http\Controllers\AdminController@downloadFile']);

//------------------- META IMPORT/EXPORT ----------------------------//

Route::get('metas/export', ['as' => 'admin.exportMeta', 'uses' => 'App\Http\Controllers\AdminController@metaExport']);
Route::get('metas/import', ['as' => 'admin.importMetaForm', 'uses' => 'App\Http\Controllers\AdminController@metaImportForm']);
Route::post('metas/import', ['as' => 'admin.importMeta', 'uses' => 'App\Http\Controllers\AdminController@metaImport']);

//-------------------------------------------------------------------//

//------------------------ REVIEW GENERATOR ------------------------//
Route::get('reviews/generator', ['as' => 'admin.review.generator.form', 'uses' => 'App\Http\Controllers\ReviewController@getGeneratorForm']);
Route::post('reviews/generator/check', ['as' => 'admin.review.generator.check', 'uses' => 'App\Http\Controllers\ReviewController@postCheckGeneratorForm']);
Route::post('reviews/generator', ['as' => 'admin.review.generator.commit', 'uses' => 'App\Http\Controllers\ReviewController@postCommitGeneratorForm']);
//-------------------------------------------------------------------//

//fix product image names
Route::get('products/fixImages',['as' => 'admin.products.fiximage','uses'=>'App\Http\Controllers\Api\ImageController@fixProductImages']);
//optimize product images
Route::get('products/optimize', ['as' => 'admin.productsOptimize', 'uses' => 'App\Http\Controllers\Api\ImageController@optimizeProductImages']);


//compress image
Route::get('image/compress',['as' => 'admin.image.compress','uses'=>'App\Http\Controllers\AdminController@compressImage']);

//update product names
Route::get('products/update/names', ['as' => 'admin.updateNames', 'uses' => 'App\Http\Controllers\AdminController@updateNames']);

//create products from crm id
Route::get('products/create_by_remote', ['as' => 'admin.createByRemote', 'uses' => 'App\Http\Controllers\AdminController@createByRemote']);

//update cities data from crm
Route::get('cities/update', ['as' => 'admin.updateCities', 'uses' => 'App\Http\Controllers\AdminController@updateCities']);

