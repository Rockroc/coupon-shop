<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('test','TestController@index');

Route::group(['namespace' => 'Api','middleware' => ['throttle:80,1']], function () {

    Route::get('goods/search','GoodsController@search');
    Route::post('goods/tkl','GoodsController@getTkl');
    Route::resource('goods', 'GoodsController');

    Route::get('categories/{id}/children','CategoryController@children');

    Route::get('cache/categories','CacheController@categories');
    Route::get('home','HomeController@index');
});