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

Route::get('/', 'IndexController@index');

// User
Route::post('/dologin', 'UsersController@doLogin');
Route::get('/account/edit', 'UsersController@edit');
Route::get('/summoner/{region}/{name}', 'UsersController@show');
Route::get('/user', 'UsersController@index');
Route::get('/login', 'UsersController@login');
Route::get('/register', 'UsersController@create');
Route::get('/register/step1', 'UsersController@step1');
Route::get('/register/step2', 'UsersController@step2');
Route::get('/register/step3', 'UsersController@step3');
Route::get('/verify_summoner', 'UsersController@verify_summoner');
Route::post('/register/save', 'UsersController@save');
Route::post('/register/save1', 'UsersController@step1_save');
Route::post('/register/save2', 'UsersController@step2_save');
Route::post('/register/save3', 'UsersController@step3_save');
Route::post('/account/update', 'UsersController@updateAccount');

// Teams
Route::get("/teams", "TeamsController@index");
Route::get("/teams/add", "TeamsController@add");
Route::post("/teams/add/rankedTeams", "TeamsController@getLoggedRankedTeams");
Route::post("/teams/add/post_action", "TeamsController@add_post");
Route::get("/teams/{region}/{tag}", "TeamsController@detail");