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

//Route::get('/', 'WelcomeController@index');
Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');
Route::post('home', 'CategoryController@products');

Route::get('admin', 'Admin\AUserController@index');

Route::get('admin/categories', 'Admin\CategoryController@index');

Route::get('admin/categories/edit', 'Admin\CategoryEditController@index');
Route::post('admin/categories/create', 'Admin\CategoryEditController@create');
Route::post('admin/categories/remove', 'Admin\CategoryEditController@remove');

Route::get('admin/products', 'Admin\ProductController@index');

Route::get('admin/products/add', 'Admin\ProductAddController@index');
Route::post('admin/products/add', 'Admin\ProductAddController@create');

Route::get('admin/products/edit/{id}', 'Admin\ProductEditController@index');
Route::post('admin/products/edit', 'Admin\ProductEditController@edit');
Route::post('admin/products/remove', 'Admin\ProductEditController@remove');

Route::get('/category/{id}', 'CategoryController@index');

Route::get('products/show/{id}', 'ProductController@index');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
