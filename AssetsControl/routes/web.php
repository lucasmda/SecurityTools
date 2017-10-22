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
    return "redireta para a página correta.";
});

Route::get('/Asset/edit', 'AssetController@edit');
Route::post('/Asset/update', 'AssetController@update');
Route::Resource('Asset', 'AssetController');
