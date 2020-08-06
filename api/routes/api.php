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

Route::group(['prefix' => 'auth', 'namespace' => 'Api\\Auth'], function () {
    Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout')->middleware('auth:api');
    Route::get('/me', 'AuthController@me')->middleware('auth:api');
});

Route::get('/status/{serviceName?}', 'Api\StatusController@status');

Route::group(['prefix' => 'auth', 'namespace' => 'Api\\Auth'], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
});

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'Api\\'
], function () {
    Route::group([
        'prefix' => '/event-types',
    ], function () {
        Route::get('/', 'EventTypeController@index');
        Route::post('/', 'EventTypeController@store');
        Route::get('/{id}', 'EventTypeController@getEventTypeById');
        Route::put('/{id}', 'EventTypeController@update');
        Route::delete('/{id}', 'EventTypeController@destroy');
    });
});
