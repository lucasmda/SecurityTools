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

Route::get('/', 'Home\HomeController@index');
Route::get('/Asset/edit', 'AssetController@edit');
Route::post('/Asset/update', 'AssetController@update');
Route::get('/Asset/search', 'AssetController@search_page');
Route::post('/Asset/search', 'AssetController@search_networks');
Route::Resource('Asset', 'AssetController');
Route::get('/get-subnet/{ip}', 'AssetController@get_localizacao');
Route::get('/get-servers-vl/{vulnerability}/{location}', 'AssetController@get_servers_vl');
