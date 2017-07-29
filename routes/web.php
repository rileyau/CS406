<?php

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

Route::get('/', 'PagesController@index');

//Pages
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

//Dashboard
Route::get('/dashboard', 'DashboardController@index');

//Boards
Route::get('/b/{name}', 'BoardsController@show');
Route::get('/board/create', 'BoardsController@create');
Route::post('/board', 'BoardsController@store');
Route::get('/b/{name}/edit', 'BoardsController@edit');
Route::put('/b/{name}', 'BoardsController@update');

//Board Posts
Route::post('/b/{name}/posts', 'PostsController@store');
Route::get('/b/{name}/posts/create', 'PostsController@create');
Route::get('/b/{name}/posts/{id}', 'PostsController@show');
Route::get('/b/{name}/posts/{id}/edit', 'PostsController@edit');
Route::put('/b/{name}/posts/{id}', 'PostsController@update');
Route::delete('/b/{name}/posts/{id}', 'PostsController@destroy');

//Subscriptions
Route::post('/b/{name}/subscription', 'SubscriptionsController@store');
Route::delete('/b/{name}/subscription', 'SubscriptionsController@destroy');

//Auth
Auth::routes();


