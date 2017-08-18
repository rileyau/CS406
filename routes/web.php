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


//Pages
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

//Dashboard
Route::get('/dashboard', 'DashboardController@index');

//Boards
Route::get('/board/create', 'BoardsController@create');
Route::post('/board', 'BoardsController@store');
Route::get('/b/{name}/search', 'BoardsController@search');
Route::get('/b/{name}/edit', 'BoardsController@edit');
Route::put('/b/{name}', 'BoardsController@update');
Route::get('/b/{name}/{filter?}', 'BoardsController@show');

//Posts
Route::get('/', 'PostsController@index');
Route::get('/subbed', 'PostsController@subbed');
Route::post('/b/{name}/posts', 'PostsController@store');
Route::get('/b/{name}/posts/create', 'PostsController@create');
Route::get('/b/{name}/posts/{id}', 'PostsController@show');
Route::get('/b/{name}/posts/{id}/edit', 'PostsController@edit');
Route::put('/b/{name}/posts/{id}', 'PostsController@update');
Route::delete('/b/{name}/posts/{id}', 'PostsController@destroy');

//Comments
Route::post('/b/{name}/posts/{post}/comments', 'CommentsController@store');
Route::delete('/b/{name}/posts/{post}/comments/{id}', 'CommentsController@destroy');
Route::put('/b/{name}/posts/{post}/comments/{id}', 'CommentsController@update');

//Subscriptions
Route::post('/b/{name}/subscription', 'SubscriptionsController@store');
Route::delete('/b/{name}/subscription', 'SubscriptionsController@destroy');

//UserPostRatings
Route::post('/posts/{post}/rating', 'UserPostRatingsController@rate');
Route::put('/posts/{post}/rating', 'UserPostRatingsController@update');
Route::delete('/posts/{post}/rating', 'UserPostRatingsController@destroy');

//Auth
Auth::routes();


