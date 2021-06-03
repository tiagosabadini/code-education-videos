<?php

use Illuminate\Http\Request;

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

Route::group(['namespace' => 'Api'], function(){
    Route::resource('categories', 'CategoryController', ['except' => ['create', 'edit']]);
    Route::resource('genres', 'GenreController', ['except' => ['create', 'edit']]);
    Route::get('/genres/{genre}/restore', [\App\Http\Controllers\Api\GenreController::class, 'restore']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
