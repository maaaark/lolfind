<?php

class IndexController extends \BaseController {
	public function index(){
      //FIServer::add_notification(24, "normal_text", "Ein reiner Test"); // Test-Nachricht an den FI-WS-Server
		$last_teams = RankedTeam::orderBy("updated_at", "DESC")->where("looking_for_players", "=", "1")->limit(5)->get();
		$last_players = Summoner::orderBy("updated_at", "DESC")->where("looking_for_team", "=", "1")->limit(5)->get();
		return View::make("index", compact('last_players', 'last_teams'));
	}

	public function email_check(){
		Mail::send('emails.test_email', array('variable' => "Variable"), function($message)
        {
            $message->to("benedict.romp@googlemail.com", "Benedict Romp")->subject('Test-Email');
        });
	}
}