<?php

class IndexController extends \BaseController {
	public function index(){
      //FIServer::add_notification(24, "normal_text", "Ein reiner Test"); // Test-Nachricht an den FI-WS-Server
		$last_teams = RankedTeam::orderBy("updated_at", "DESC")->limit(5)->get();
		$last_players = Summoner::orderBy("updated_at", "DESC")->limit(5)->get();
		return View::make("index", compact('last_players', 'last_teams'));
	}
}