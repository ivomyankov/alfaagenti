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

Route::get('/dash', function () {
    return view('vendor/adminlte/dashboard');
});
Route::get('/', 'App\Http\Controllers\ImotiController@getImoti')->name('home');
Route::get('/imoti', 'App\Http\Controllers\ImotiController@getImoti')->name('imoti');
Route::get('/imoti/naem', 'App\Http\Controllers\ImotiController@getImoti')->name('naem');
Route::get('/imoti/prodajba', 'App\Http\Controllers\ImotiController@getImoti')->name('prodajba');
Route::get('/imoti/filtar', 'App\Http\Controllers\ImotiController@getImotiFiltar');

//Route::get('/ekip', 'App\Http\Controllers\HomeController@getEkip')->name('getEkip');

Route::get('/imot/{id}', 'App\Http\Controllers\ImotiController@getHomeImot')->name('getImot');

Route::get('/dashboard', 'App\Http\Controllers\DashboardController@getDashboard')->name('dashboard');
Route::get('/dashboard/imoti', 'App\Http\Controllers\DashboardController@getImoti')->name('dashImoti');
Route::get('/dashboard/imot/{id}', 'App\Http\Controllers\DashboardController@getImot')->middleware('rights')->name('dashImot');
Route::get('/dashboard/{id}/imoti', 'App\Http\Controllers\ImotiController@agentsImoti')->name('dash-agents-imoti');

Route::get('/dashboard/agenti', 'App\Http\Controllers\DashboardController@agenti')->name('agenti');

Route::post('/dashboard/imageupload', 'App\Http\Controllers\ImageController@imageUpload')->name('imageUpload');
Route::post('/dashboard/imagereposition', 'App\Http\Controllers\ImageController@imageReposition')->name('imageReposition');
Route::post('/dashboard/imagedelete/{id}', 'App\Http\Controllers\ImageController@imageDelete')->name('imageDelete');

Route::get('/dashboard/switchagent/{id}', 'App\Http\Controllers\DashboardController@switchAgent')->name('switchAgent');

Route::post('/ban/{id}', 'App\Http\Controllers\DashboardController@ban')->name('ban');
Route::post('/unban/{id}', 'App\Http\Controllers\DashboardController@unban')->name('unban');

Route::get('/test2', 'App\Http\Controllers\HomeController@test2');

Auth::routes();

Route::get('/home', [App\Http\Controllers\ImotiController::class, 'index'])->name('home');

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});
