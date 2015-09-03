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
Route::get('/user', 'UsersController@index');
Route::get('/login', 'UsersController@login');
Route::get('/logout', 'UsersController@logout');
Route::get('/register', 'UsersController@create');
Route::get('/register/step1', 'UsersController@step1');
Route::get('/register/step2', 'UsersController@step2');
Route::get('/register/step3', 'UsersController@step3');
Route::get('/register/step4', 'UsersController@step4');
Route::get('/register/find-summoner', 'UsersController@register_find_summoner');
Route::get('/register/find-summoner/{summoner_id}/{region}', 'UsersController@register_find_summoner_action_save');
Route::post('/register/find-summoner', 'UsersController@register_find_summoner_action');
Route::get('/settings', 'UsersController@settings');
Route::post('/save_settings', 'UsersController@save_settings');
Route::get('/verify_summoner', 'UsersController@verify_summoner');
Route::post('/register/save', 'UsersController@save');
Route::post('/register/save1', 'UsersController@step1_save');
Route::post('/register/save2', 'UsersController@step2_save');
Route::post('/register/save3', 'UsersController@step3_save');
Route::post('/register/save4', 'UsersController@step4_save');
Route::post('/account/update', 'UsersController@updateAccount');
Route::post('/notifications/get', "UsersController@getNotification");
Route::get('/applications', "UsersController@applications");

// Teams
Route::get("/teams", "TeamsController@index");
Route::get("/teams/league/{league1}", "TeamsController@index");
Route::get("/teams/league/{league1}/{league2}", "TeamsController@index");
Route::post("/teams/team_list_suggestions", "TeamsController@list_suggestions");
Route::get("/teams/add", "TeamsController@add");
Route::post("/teams/add/rankedTeams", "TeamsController@getLoggedRankedTeams");
Route::post("/teams/add/post_action", "TeamsController@add_post");
Route::get("/teams/add/success/{id}", "TeamsController@add_success");
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
Route::post("/teams/invite/start", "TeamsController@invite_lightbox");
Route::post("/teams/invite/post", "TeamsController@invite_lightbox_post");
Route::post("/teams/invite/show", "TeamsController@invite_lightbox_show");
Route::post("/teams/invite/delete", "TeamsController@invite_lightbox_delete");

// Teams-Premium
Route::get("/teams/{region}/{tag}/settings/config-rights", "TeamsPremiumController@config_rights");
Route::post("/teams/{region}/{tag}/settings/config-rights/action", "TeamsPremiumController@config_rights_action");
Route::get("/teams/{region}/{tag}/calendar", "TeamsPremiumController@calendar");
Route::get("/teams/{region}/{tag}/calendar/ajax/{month}/{year}", "TeamsPremiumController@calendar_ajax");
Route::get("/teams/{region}/{tag}/calendar/lightbox", "TeamsPremiumController@calendar_day_lightbox");
Route::post("/teams/{region}/{tag}/calendar/lightbox/add", "TeamsPremiumController@calendar_day_lightbox_add");
Route::post("/teams/{region}/{tag}/calendar/lightbox/event", "TeamsPremiumController@calendar_day_lightbox_event");


// Players
Route::get("/players", "PlayersController@index");
Route::get("/players/{lane}", "PlayersController@index");
Route::post("/players/player_list_suggestions", "PlayersController@list_suggestions");
Route::get('/summoner/{region}/{name}', 'UsersController@show');
Route::get('/summoner/{region}/{name}/ajax', 'UsersController@ajax_summoner_update');

// PW Reset / Reminder

Route::get("/password/forgot", "RemindersController@getRemind");
Route::get("/password/reset", "RemindersController@getReset");
Route::controller('password', 'RemindersController');


// Pages
Route::get("/ringer", "BaseController@ringer");
Route::get("/tos", "BaseController@tos");
Route::get("/legal", "BaseController@legal");
Route::get("/mail", "BaseController@mail");

// Blog
Route::get("/blog", "BlogController@index");
Route::get("/blog/{date}/{id}-{name}", "BlogController@detail");

// Admin Panel
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function(){
    if(Auth::check() && Auth::user()->hasRole("admin")){
    	Route::get('/', "AdminController@index");
    	Route::get('/network_server', "AdminController@network_server");
        Route::get('/statistics', "AdminController@statistics");

        Route::get('/users', "AdminUsersController@index");
        Route::get('/users/search', "AdminUsersController@search");
        Route::get('/users/summoner/{region}/{summoner_id}/', "AdminUsersController@summoner");
    	Route::get('/users/summoner/{region}/{summoner_id}/verify_reset', "AdminUsersController@summoner_verify_reset");

    	Route::get('/blog', "AdminBlogController@index");
    	Route::get('/blog/post/{id}', "AdminBlogController@post");
    	Route::post('/blog/post/{id}/action', "AdminBlogController@post_action");
    	Route::get('/blog/post/{id}/delete', "AdminBlogController@delete_action");
	}
});

// Error Pages
App::missing(function($exception){
    return Response::view('404_error', array(), 404);
});