<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('admin', 'Admin\AUserController@index');

Route::get('admin/categories', 'Admin\CategoryController@index');

Route::get('admin/categories/edit', 'Admin\CategoryEditController@index');
Route::post('admin/categories/create', 'Admin\CategoryEditController@create');
Route::post('admin/categories/remove', 'Admin\CategoryEditController@remove');

Route::get('admin/products/add', 'Admin\ProductController@index');
Route::post('admin/products/add', 'Admin\ProductController@create');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
