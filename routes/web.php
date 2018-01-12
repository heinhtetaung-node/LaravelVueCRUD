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

Route::get('/', function () {
    return view('welcome');
});


Route::resource('items','ItemController');
Route::resource('categories','CategoryController');

Route::get('/category', function () {
    return view('welcome');
});
Route::get('/sub_category',function(){
	return view('welcome');
});
Route::get('/item/item-transition', function () {
    return view('welcome');
});
