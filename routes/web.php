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

Route::get('/', [App\Http\Controllers\MainPageController::class, 'render']);

Route::post('/mainpage/send-form', [App\Http\Controllers\MainPageController::class, 'sendMail']);

Route::get('/cache_on', function(){
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
});

Route::get('/cache_off', function(){
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
});

Route::get('/cache', function(){
    echo "Test";
});
