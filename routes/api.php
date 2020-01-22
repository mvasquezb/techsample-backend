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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::get('/home', 'HomeController@index');
    Route::get('/reports', 'ReportController@index');
    Route::resource('users', 'UsersController');
});

Route::post('/forgot-password', 'AuthController@forgotPassword');
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');