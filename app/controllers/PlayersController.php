<?php

class PlayersController extends \BaseController {
    public function index(){
        return View::make("players.index");
    }

}