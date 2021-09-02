<?php

use Illuminate\Support\Facades\Route;

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

//Category
Route::get('/category', 'CategoryController@index');

Route::put('/category/update', 'CategoryController@update');

Route::post('/category/store', 'CategoryController@store');

Route::delete('/category/destroy/{id}', 'CategoryController@destroy');

Route::get('/category/show', 'CategoryController@show');

//Product

Route::get('/product', 'ProductController@index');

Route::put('/product/update', 'ProductController@update');

Route::post('/product/store', 'ProductController@store');

Route::delete('/product/destroy/{id}', 'ProductController@destroy');

Route::get('/product/show', 'ProductController@show');