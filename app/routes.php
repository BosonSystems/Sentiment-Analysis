<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::model('user', 'User');
Route::model('comment', 'Comment');
Route::model('post', 'Post');
Route::model('role', 'Role');
Route::model('movie', 'Movie');
Route::model('category', 'Category');
Route::model('word', 'Word');

/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */
Route::pattern('comment', '[0-9]+');
Route::pattern('post', '[0-9]+');
Route::pattern('user', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('movie', '[0-9]+');
Route::pattern('category', '[0-9]+');
Route::pattern('word', '[0-9]+');
Route::pattern('type', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{

    # Comment Management
    Route::get('comments/{comment}/edit', 'AdminCommentsController@getEdit');
    Route::post('comments/{comment}/edit', 'AdminCommentsController@postEdit');
    Route::get('comments/{comment}/delete', 'AdminCommentsController@getDelete');
    Route::post('comments/{comment}/delete', 'AdminCommentsController@postDelete');
    Route::controller('comments', 'AdminCommentsController');

    # Blog Management
    Route::get('blogs/{post}/show', 'AdminBlogsController@getShow');
    Route::get('blogs/{post}/edit', 'AdminBlogsController@getEdit');
    Route::post('blogs/{post}/edit', 'AdminBlogsController@postEdit');
    Route::get('blogs/{post}/delete', 'AdminBlogsController@getDelete');
    Route::post('blogs/{post}/delete', 'AdminBlogsController@postDelete');
    Route::controller('blogs', 'AdminBlogsController');

    # User Management
    Route::get('users/{user}/show', 'AdminUsersController@getShow');
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
    Route::controller('users', 'AdminUsersController');

    # User Role Management
    Route::get('roles/{role}/show', 'AdminRolesController@getShow');
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
    Route::controller('roles', 'AdminRolesController');

     

    Route::get('movie/create', 'AdminMovieController@getCreate');
    Route::post('movie/create', 'AdminMovieController@postCreate');
    Route::get('movie/{movie}/edit', 'AdminMovieController@getEdit');
    Route::post('movie/{movie}/edit', 'AdminMovieController@postEdit');
    Route::get('movie/{movie}/delete', 'AdminMovieController@getDelete');
    Route::get('movie/{movie}/view', 'AdminMovieController@getView');
    
    Route::get('movie/{movie}/analyse', 'AdminMovieController@getAnalyse');

    Route::controller('movie', 'AdminMovieController');

    Route::get('category/create', 'AdminCategoryController@getCreate');
    Route::post('category/create', 'AdminCategoryController@postCreate');
    Route::get('category/{category}/edit', 'AdminCategoryController@getEdit');
    Route::post('category/{category}/edit', 'AdminCategoryController@postEdit');
    Route::get('category/{category}/delete', 'AdminCategoryController@getDelete');
    Route::controller('category', 'AdminCategoryController');

    Route::get('words', 'AdminWordController@getIndex');
    Route::get('words/data', 'AdminWordController@getData');
    Route::get('words/create', 'AdminWordController@getCreate');
    Route::post('words/create', 'AdminWordController@postCreate');
    Route::get('words/{word}/edit', 'AdminWordController@getEdit');
    Route::post('words/{word}/edit', 'AdminWordController@postEdit');
    Route::get('words/{word}/delete', 'AdminWordController@getDelete');

    Route::get('sentiment', 'AdminWordController@getSentiment');
    Route::get('sentiment/data', 'AdminWordController@getSentimentData');
    Route::get('sentiment/create', 'AdminWordController@getSentimentCreate');
    Route::post('sentiment/create', 'AdminWordController@postSentimentCreate');
    Route::get('sentiment/{word}/edit', 'AdminWordController@getSentimentEdit');
    Route::post('sentiment/{word}/edit', 'AdminWordController@postSentimentEdit');
    Route::get('word/{movie}/newwords', 'AdminWordController@getNewwords');
    Route::post('word/{movie}/newwords', 'AdminWordController@postNewwords');

    Route::get('negative', 'AdminWordController@getNegative');
    Route::get('negative/data', 'AdminWordController@getNegativeData');
    Route::get('negative/create', 'AdminWordController@getNegativeCreate');
    Route::post('negative/create', 'AdminWordController@postNegativeCreate');
    Route::get('negative/{word}/edit', 'AdminWordController@getNegativeEdit');
    Route::post('negative/{word}/edit', 'AdminWordController@postNegativeEdit');
    Route::get('negative/delete/{word}/{type}', 'AdminWordController@getDelete');

    Route::controller('word', 'AdminWordController');

  //  Route::get('/word/{id}', 'AdminMovieController@wordAnalysis');
  //  Route::get('/market/{isin}', 'AdminMovieController@stock');



    # Admin Dashboard
    Route::controller('/', 'AdminMovieController');
});


/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

// User reset routes
Route::get('user/reset/{token}', 'UserController@getReset');
// User password reset
Route::post('user/reset/{token}', 'UserController@postReset');
//:: User Account Routes ::
Route::post('user/{user}/edit', 'UserController@postEdit');

Route::get('user/{user}/change', 'UserController@getChange');
Route::post('user/{user}/change', 'UserController@postChange');


//:: User Account Routes ::
Route::post('user/login', 'UserController@postLogin');

# User RESTful Routes (Login, Logout, Register, etc)
Route::controller('user', 'UserController');

//:: Application Routes ::

# Filter for detect language
Route::when('contact-us','detectLang');

# Contact Us Static Page
Route::get('contact-us', function()
{
    // Return about us page
    return View::make('site/contact-us');
});

# Posts - Second to last set, match slug
Route::get('{postSlug}', 'BlogController@getView');
Route::post('{postSlug}', 'BlogController@postView');

# Index Page - Last route, no matches

Route::get('movie/create', 'MovieController@getCreate');
Route::post('movie/create', 'MovieController@postCreate');
Route::get('movie/{movie}/edit', 'MovieController@getEdit');
Route::post('movie/{movie}/edit', 'MovieController@postEdit');
Route::get('movie/{movie}/view', 'MovieController@getView');

Route::get('movie/{movie}/analyse', 'MovieController@getAnalyse');

Route::controller('movie', 'MovieController');

Route::get('movie/create', 'MovieController@getCreate');
Route::get('/', array('before' => 'detectLang','uses' => 'MovieController@getIndex'));
