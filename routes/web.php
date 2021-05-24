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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
// // topページ
// Route::get('/', 'ProductController@index')->name('product.index');
// // 商品詳細ページ
// Route::get('/product/{id}', 'ProductController@show')->name('product.show');
// productでグループ化
Route::name('product.')
->group(function () {
    Route::get('/', 'ProductController@index')->name('index');//product.index
    Route::get('/product/{id}', 'ProductController@show')->name('show');//product.show
});
// line-itemでグループ化
Route::name('line_item.')
->group(function () {
    Route::post('/line_item/create', 'LineItemController@create')->name('create');
    Route::post('/line_item/delete', 'LineItemController@delete')->name('delete');
});
// cartでグループ化
Route::name('cart.')
->group(function () {
    Route::get('/cart', 'CartController@index')->name('index');
    // 決済
    Route::get('/cart/checkout', 'CartController@checkout')->name('checkout');
    // 決済成功したら
    Route::get('/cart/success', 'CartController@success')->name('success');
});