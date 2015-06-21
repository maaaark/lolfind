<?php

class IndexController extends \BaseController {
	public function index(){
        //FIServer::send("teeest"); // Test-Nachricht an den FI-WS-Server
		return View::make("index");
	}
}