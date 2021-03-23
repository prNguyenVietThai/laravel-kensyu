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

Route::get('/', 'AuthController@home')->name('home');
Route::get('/login', 'AuthController@showLoginPage')->name('login');
Route::post('/login', 'AuthController@login')->name('auth.login');
Route::get('/signup', 'AuthController@showSignupPage')->name('signup');
Route::post('/signup', 'AuthController@signup')->name('auth.signup');
Route::get('/logout', 'AuthController@logout')->name('auth.logout');

Route::group(['prefix' => 'post', 'middleware' => ['auth']], function () {
    Route::get('/create', 'PostController@create')->name('createPostPage');
    Route::post('/create', 'PostController@store')->name('post.store');
    Route::get('/edit/{id}', 'PostController@edit')->name('editPostPage');
    Route::patch('/edit/{id}', 'PostController@update')->name('post.update');;
    Route::delete('/delete/{id}', 'PostController@destroy')->name('post.delete');;
});
Route::group(['prefix' => 'post'], function () {
    Route::get('/show/{id}', 'PostController@show')->name('showPostPage');
});

Route::get('/image/{id}', 'ImageController@show')->name('image.show');

Route::group(['prefix' => 'tag', 'middleware' => ['auth']], function () {
    Route::post('/create', 'TagController@store')->name('tag.store');
});