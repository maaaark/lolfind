<?php

class PlayersController extends \BaseController {
    public function index($lane = false){
        if($lane == false){
            $player_list = Summoner::where("looking_for_team", "=", 1)->paginate(10);
        } else {
            $lane = trim(strtolower($lane));
            if($lane == "top" || $lane == "mid" || $lane == "support" || $lane == "jungle" || $lane == "adc"){
                $player_list = Summoner::where("looking_for_team", "=", 1)->where("search_".$lane, "=", 1)->paginate(10);
            } else {
                $player_list = Summoner::where("looking_for_team", "=", 1)->paginate(10);
            }
        }
        return View::make("players.index", compact('player_list'));
    }

    public function details($id){
        $player_list = Summoner::where("looking_for_team", "=", 1)->get();
    	return View::make("players.details", compact('player_list'));
    }

    public function list_suggestions(){
        $player_list = Summoner::where('looking_for_team',"=",1);

        if(Input::get("league") != "any") {
            $player_list->where('solo_tier',"LIKE", '%'.strtoupper(Input::get("league")).'%');
        }

        if(Input::get("region") != "any") {
            $player_list->where('region',"=",Input::get("region"));
        }

        if(Input::get("main_lang") != "any") {
            $player_list->where('main_lang',"=",Input::get("main_lang"))->orWhere('sec_lang',"=",Input::get("sec_lang"));
            //$ranked_teams->where('looking_for_lang_second',"=",Input::get("main_lang"));
        }



        if(Input::get("prime_role") != "any") {
            if(Input::get("prime_role") == "adc") {
                $player_list->where('search_adc',"=",1);
            }
            if(Input::get("prime_role") == "support") {
                $player_list->where('search_support',"=",1);
            }
            if(Input::get("prime_role") == "jungle") {
                $player_list->where('search_jungle',"=",1);
            }
            if(Input::get("prime_role") == "top") {
                $player_list->where('search_top',"=",1);
            }
            if(Input::get("prime_role") == "mid") {
                $player_list->where('search_mid',"=",1);
            }
        }

        $player_list = $player_list->paginate(10);


        return View::make("players.suggestion_list", array(
            "player_list" => $player_list
        ));
    }
}