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

Route::resources([
    'albums' => 'AlbumsController',
    'articles' => 'ArticlesController',
    'photos' => 'PhotosController',
    'users' => 'UsersController',
    'videos' => 'VideosController',
]);

// ***ARTICLES***
Route::get('archiveArticles/{year}', 'ArchivesController@archiveArticles')->name('archiveArticles');

// ***ARTICLES/CATEGORIES/TAGS***
Route::get('articles/{article}/tags/{tag}', 'TagsController@articleTag')->name('articleTags');

// ***COMMENTS***
Route::post('/addComment/{commentable_id}/{commentable_type}', 'CommentsController@store');
Route::get('/editComment/{comment}', 'CommentsController@edit');
Route::put('/editComment/{comment}', 'CommentsController@update')->name('updateComment');
Route::get('/deleteComment/{comment}', 'CommentsController@destroy');

// ***CONTACT***
Route::get('/contact', 'ContactsController@formContact')->name('contact');
Route::post('/sendContact', 'ContactsController@sendContact')->name('sendContact');

// ***HOME PAGE***
Route::get('/', 'HomeController@index')->name('home');

// ***USERS*** like, unlike
Route::get('/like/{likeable_id}/{likeable_type}', 'LikesController@like');
Route::get('/unlike/{likeable_id}/{likeable_type}', 'LikesController@unlike');

// ***VIDEOS***
Route::get('archiveVideos/{year}/{month}', 'ArchivesController@archiveVideos')->name('archiveVideos');

// ***VIDEOS/TAGS***
Route::get('videos/{video}/tags/{tag}', 'TagsController@videoTag')->name('videoTags');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
