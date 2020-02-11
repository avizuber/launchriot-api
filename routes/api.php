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

Route::prefix('v1')->group(function(){
    Route::post('login', 'API\AuthController@login');
    Route::post('register', 'API\AuthController@register');
    
    Route::group(['middleware' => 'auth:api'], function() {
		/* User */
		Route::get('logout', 'API\AuthController@logout');
		Route::get('getUser', 'API\AuthController@getUser');
		/* Thing */
		Route::post('createThing', 'API\ThingController@createThing');
		Route::get('getUserThings', 'API\ThingController@getUserThings');
		Route::get('getThing', 'API\ThingController@getThing');
		Route::post('updateThing', 'API\ThingController@updateThing');
		Route::post('deleteThing', 'API\ThingController@deleteThing');
    });
});
