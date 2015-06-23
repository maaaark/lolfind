<?php

class IndexController extends \BaseController {
	public function index(){
      //FIServer::add_notification(24, "normal_text", "Ein reiner Test"); // Test-Nachricht an den FI-WS-Server
		return View::make("index");
	}
}