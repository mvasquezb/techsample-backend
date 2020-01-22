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
    Route::post('users.edit', 'RegisterController@update');
});

Route::namespace('Auth')->group(function () {
    Route::post('/forgot-password', 'LoginController@forgotPassword');
    Route::post('/login', 'LoginController@login');
    Route::post('/register', 'RegisterController@create');
});