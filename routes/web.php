<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sells/search', function() {
    return response()
        ->json(\App\Product::where('amount', '>', 0)->get());
});

Auth::routes();

Route::resource("products","ProductController");
Route::resource("sells","SellController");

Route::get('/home', 'HomeController@index');
