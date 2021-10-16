<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/test', 'App\Http\Controllers\HomeController@test');

Route::delete('/test', 'App\Http\Controllers\ImageController@imageDelete');

Route::get('/test1', 'App\Http\Controllers\HomeController@test1');