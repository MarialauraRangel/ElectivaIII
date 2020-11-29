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

/////////////////////////////////////// AUTH ////////////////////////////////////////////////////
Route::group(['prefix' => 'auth'], function() {
	Route::post('/login', 'Api\AuthController@login');
	Route::post('/register', 'Api\AuthController@signUp');
	Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

	Route::group(['middleware' => 'auth:api'], function() {
		Route::get('/logout', 'Api\AuthController@logout');
		Route::get('/profile', 'Api\AuthController@profile');
		Route::get('/profile/orders', 'Api\AuthController@orders');
		Route::get('/profile/orders/{order}', 'Api\AuthController@order');
	});
});

/////////////////////////////////////// GET DATA ////////////////////////////////////////////////////
Route::get('/categories', 'Api\DataController@categories');
Route::get('/categories/{category}/subcategories', 'Api\DataController@categorySubcategories');
Route::get('/categories/{category}/products', 'Api\DataController@categoryProducts');
Route::get('/subcategories', 'Api\DataController@subcategories');
Route::get('/subcategories/{subcategory}/products', 'Api\DataController@subcategoryProducts');
Route::get('/clients', 'Api\DataController@clients');
Route::get('/clients/{client}', 'Api\DataController@client');
Route::get('/clients/{client}/orders', 'Api\DataController@clientOrders');
Route::get('/clients/{client}/orders/{order}', 'Api\DataController@clientOrder');
Route::get('/products', 'Api\DataController@products');
Route::get('/products/{product}', 'Api\DataController@product');
