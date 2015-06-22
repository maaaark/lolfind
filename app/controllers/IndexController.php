<?php

class IndexController extends \BaseController {
	public function index(){
        //FIServer::add_notification(32, "test", "value100"); // Test-Nachricht an den FI-WS-Server
		return View::make("index");
	}
}