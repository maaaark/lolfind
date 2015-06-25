<?php

class PlayersController extends \BaseController {
    public function index(){
        return View::make("players.index");
    }

    public function details($id){
    	return View::make("players.details", compact(''));
    }

}