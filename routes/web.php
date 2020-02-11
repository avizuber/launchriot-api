<?php

/*
|--------------------------------------------------------------------------
| SPA Routes
|--------------------------------------------------------------------------
|
| This overrides all Laravel native routes to allow an internal React SPA to work.
| This is experimental
|


Route::view('/{path?}', 'index');

*/

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


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/*
|--------------------------------------------------------------------------
|  Web Routes: Admin
|--------------------------------------------------------------------------
|
| Routes for web admins and the general system
|
*/


Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:isAdmin')->group(function(){
	Route::resource('/users', 'UsersController', ['except' => ['create', 'store']]);
	Route::get('/dashboard', 'AdminDashboardController@index');
});

