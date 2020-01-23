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

Route::middleware('auth:api')->group(function () {
    Route::get('/home', 'HomeController@index');
    Route::get('/reports', 'ReportController@index');
    Route::resource('users', 'UsersController');
    Route::get('/user', 'AuthController@getUser');
});

Route::namespace('Auth')->group(function () {
    Route::post('/forgot-password', 'ForgotPasswordController@getPasswordResetToken');
    Route::post('/reset-password', 'ResetPasswordController@reset');
    Route::get('/reset-password', 'ResetPasswordController@showResetForm')->name('password.reset');
});

Route::get('/login', 'AuthController@showLogin')->name('login');
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');
