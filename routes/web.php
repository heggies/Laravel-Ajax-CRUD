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

Route::group(['prefix' => 'ajax'], function() {
  Route::get('get', 'MyController@get_to_index');
  Route::post('get', 'MyController@get_kontak_detail');
  Route::post('store', 'MyController@store');
  Route::post('delete/{id}', 'MyController@delete');
  Route::post('update', 'MyController@update');
});
