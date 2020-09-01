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
    Route::post('/refresh', 'AuthController@refresh');
    Route::post('/forgot-password', 'AuthController@sendLinkForgotPassword');
    Route::post('/reset-password', 'AuthController@resetPassword')->name('password.reset');
    Route::post('/login', 'AuthController@login')->name('login');
    Route::post('/logout', 'AuthController@logout')->middleware('auth:api');
    Route::get('/me', 'AuthController@me')->middleware('auth:api');
    Route::post('/email/verify', 'EmailVerificationController@verify')->name('verification.verify');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::get('/status/{serviceName?}', 'Api\StatusController@status');
Route::post('/mail', 'Api\StatusController@mail');
Route::post('/broadcast', 'Api\StatusController@event');

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'Api\\'
], function () {
    Route::group([
        'prefix' => '/event-types',
    ], function () {
        Route::post('/', 'EventTypeController@store');
        Route::get('/{id}', 'EventTypeController@getEventTypeById');
        Route::put('/{id}', 'EventTypeController@update');
        Route::put('/{id}/disabled', 'EventTypeController@changeDisabledById');
        Route::post('/{id}/clone', 'EventTypeController@cloneEventTypeById');
        Route::put('/{id}/internal-note', 'EventTypeController@updateInternalNoteById');
        Route::post('/{id}/custom-fields', 'EventTypeController@saveCustomFieldsByEventTypeId');
        Route::put('/{id}/custom-fields', 'EventTypeController@updateCustomFieldsByEventTypeId');
        Route::delete('/{id}', 'EventTypeController@destroy');
    });
    Route::group([
        'prefix' => '/event-types',
    ], function () {
        Route::get('/', 'EventTypeController@index');
        Route::get('/nickname/{nickname}', 'EventTypeController@getEventTypesByNickname');
        Route::get('/{id}', 'EventTypeController@getEventTypeById');
    });
});
Route::group([
    'prefix' => '/event-types',
    'namespace' => 'Api\\'
], function () {
    Route::get('/nickname/{nickname}', 'EventTypeController@getEventTypesByNickname');
    Route::get('/{id}/custom-fields', 'EventTypeController@getCustomFieldsById');
    Route::get('{id}/tags', 'TagController@getTagsByEventTypeId');
});

Route::group([
    'prefix' => 'public'
], function () {
    Route::get('/users/{nickname}/event-types/{id}', 'Api\\EventTypeController@getEventTypeByIdAndNickname');
});
Route::get('/event-types/{id}/availabilities', 'Api\\EventTypeController@getAvailableTime');

Route::group([
    'namespace' => 'Api\\',
    'prefix' => '/events'
], function () {
    Route::post('/', 'EventController@store');
    Route::get('/', 'EventController@index');
    Route::get('/emails', 'EventController@getEventsEmails');
});

Route::group([
    'namespace' => 'Api\\',
    'prefix' => '/tags'
], function () {
    Route::get('/events', 'TagController@getTagsByEventDateRange');
    Route::post('/', 'TagController@store');
});

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'Api\\',
    'prefix' => '/profiles',
], function () {
    Route::put('/me', 'UserController@store');
    Route::delete('/me', 'UserController@delete');
    Route::put('/me/password', 'UserController@updatePassword');
});

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'Api\\',
    'prefix' => '/files',
], function () {
    Route::post('/', 'UploadController@store');
});

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'Api\\',
    'prefix' => '/social-accounts',
], function () {
    Route::get('/calendars', 'SocialAccountController@calendars');
    Route::delete('/calendars/{provider?}/', 'SocialAccountController@destroyCalendar');
});

Route::get('/social-accounts/{provider?}/oauth', 'Api\\SocialAccountController@oauth');
Route::get('/social-accounts/{provider?}/oauthResponse', 'Api\\SocialAccountController@oauthResponse');
