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

Route::get('/', 'IndexController@index')->name('index');
Route::get('/temperature','IndexController@show')->name('showTemp');
Route::post('/temperature','IndexController@store')->name('check');
Route::get('/cities','AjaxController@citiesByCountry')->name('citiesByCountry');
