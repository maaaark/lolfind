<?php

class PlayersController extends \BaseController {
    public function index(){
        $player_list = Summoner::where("looking_for_team", "=", 1)->get();
        return View::make("players.index", compact('player_list'));
    }

    public function details($id){
        $player_list = Summoner::where("looking_for_team", "=", 1)->get();
    	return View::make("players.details", compact('player_list'));
    }

    public function list_suggestions(){

        print_r(Input::all());
        $player_list = Summoner::where('looking_for_team',"=",1);


        if(Input::get("league") != "any") {
            $player_list->where('solo_tier',"LIKE", '%'.Input::get("league").'%');
        }

        if(Input::get("region") != "any") {
            $player_list->where('region',"=",Input::get("region"));
        }

        /*
        if(Input::get("unranked_search") == true) {
            if(Input::get("league") != "any") {
                $ranked_teams->where('league_prediction',"=",Input::get("league"));
            }
        }


        if(Input::get("main_lang") != "any") {
            $player_list->where('looking_for_lang',"=",Input::get("main_lang"));
            //$ranked_teams->where('looking_for_lang_second',"=",Input::get("main_lang"));
        }
        */


        /*
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
        */
        $player_list = $player_list->paginate(10);


        return View::make("teams.suggestion_list", array(
            "player_list" => $player_list
        ));
    }
}