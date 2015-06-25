<?php

class PlayersController extends \BaseController {
    public function index(){
        return View::make("players.index");
    }

    public function details($id){
    	return View::make("players.details", compact(''));
    }

    public function list_suggestions(){
    	echo "LIST SUGGESTIONS:<br/>";
    	print_r(Input::all());
    }
}