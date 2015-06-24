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
Route::get('/logout', 'UsersController@logout');
Route::get('/register', 'UsersController@create');
Route::get('/register/step1', 'UsersController@step1');
Route::get('/register/step2', 'UsersController@step2');
Route::get('/register/step3', 'UsersController@step3');
Route::get('/settings', 'UsersController@settings');
Route::post('/save_settings', 'UsersController@save_settings');
Route::get('/verify_summoner', 'UsersController@verify_summoner');
Route::post('/register/save', 'UsersController@save');
Route::post('/register/save1', 'UsersController@step1_save');
Route::post('/register/save2', 'UsersController@step2_save');
Route::post('/register/save3', 'UsersController@step3_save');
Route::post('/account/update', 'UsersController@updateAccount');
Route::post('/notifications/get', "UsersController@getNotification");

// Teams
Route::get("/teams", "TeamsController@index");
Route::get("/teams/league/{league1}", "TeamsController@index");
Route::get("/teams/league/{league1}/{league2}", "TeamsController@index");
Route::post("/teams/team_list_suggestions", "TeamsController@list_suggestions");
Route::get("/teams/add", "TeamsController@add");
Route::post("/teams/add/rankedTeams", "TeamsController@getLoggedRankedTeams");
Route::post("/teams/add/post_action", "TeamsController@add_post");
Route::get("/teams/update_team/{team_id}", "TeamsController@updateTeam");
Route::get("/teams/{region}/{tag}", "TeamsController@detail");
Route::get("/teams/{region}/{tag}/members", "TeamsController@detail");
Route::get("/teams/{region}/{tag}/settings", "TeamsController@settings");
Route::get("/teams/{region}/{tag}/applications", "TeamsController@applications");
Route::get("/teams/{region}/{tag}/applications/{id}", "TeamsController@application_detail");
Route::get("/teams/{region}/{tag}/applications/{id}/delete", "TeamsController@application_delete");
Route::post("/teams/settings/post", "TeamsController@settings_post");
Route::post("/teams/apply/start", "TeamsController@apply_lightbox");
Route::post("/teams/apply/post", "TeamsController@apply_lightbox_post");


// Players
Route::get("/players", "PlayersController@index");