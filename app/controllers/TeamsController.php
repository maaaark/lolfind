<?php

class TeamsController extends \BaseController {
    private $list_suggestion_limit = 30;
    
    public function index($league1 = false, $league2 = false){
        $own_teams = array();
        if(Auth::check()){
            $teams_player = RankedTeamPlayer::where("summoner_id", "=", Auth::user()->summoner->summoner_id)->get();
            foreach($teams_player as $player){
                $ranked_team_temp = RankedTeam::where("id", "=", $player->team)->first();
                if(isset($ranked_team_temp) && $ranked_team_temp && $ranked_team_temp->id > 0){
                    $own_teams[] = $ranked_team_temp;
                }
            }
        }

        $team_list = RankedTeam::where("looking_for_players", "=", 1)->paginate(10);
        return View::make('teams.index', compact('team_list', 'own_teams'));
    }

    public function list_suggestions(){
        print_r(Input::all());
        $ranked_teams = RankedTeam::where("name","!=", "");
        $ranked_teams->where('looking_for_players',"=",1);

        if(Input::get("league") != "any") {
            if(Input::get("unranked_search") == true && Input::get("unranked_search") != "false") {
                $ranked_teams->where('ranked_league_5',"LIKE", '%'.Input::get("league").'%')->orWhere('league_prediction',"=",Input::get("league"));
            } else {
                $ranked_teams->where('ranked_league_5',"LIKE", '%'.Input::get("league").'%')->where("ranked_league_5", "!=", "")->where("ranked_league_5", "!=", "none");
            }

        } else {
            if(Input::get("unranked_search") == false || Input::get("unranked_search") == "false"){
                $ranked_teams->where('ranked_league_5',"!=", "none")->where('ranked_league_5',"!=", "");
            }
        }

        if(Input::get("region") != "any") {
            $ranked_teams->where('region',"=",Input::get("region"));
        }

        /*
        if(Input::get("unranked_search") == true) {
            if(Input::get("league") != "any") {
                $ranked_teams->where('league_prediction',"=",Input::get("league"));
            }
        }
        */

        if(Input::get("main_lang") != "any") {
            $ranked_teams->where('looking_for_lang',"=",Input::get("main_lang"));
            //$ranked_teams->where('looking_for_lang_second',"=",Input::get("main_lang"));
        }

        if(Input::get("prime_role") != "any") {
            if(Input::get("prime_role") == "adc") {
                $ranked_teams->where('looking_for_adc',"=",1);
            }
            if(Input::get("prime_role") == "support") {
                $ranked_teams->where('looking_for_support',"=",1);
            }
            if(Input::get("prime_role") == "jungle") {
                $ranked_teams->where('looking_for_jungle',"=",1);
            }
            if(Input::get("prime_role") == "top") {
                $ranked_teams->where('looking_for_top',"=",1);
            }
            if(Input::get("prime_role") == "mid") {
                $ranked_teams->where('looking_for_mid',"=",1);
            }
        }

        $ranked_teams = $ranked_teams->paginate(10);

        return View::make("teams.suggestion_list", array(
            "ranked_teams" => $ranked_teams
        ));
    }
    
    public function detail($region, $tag){
        $ranked_team = RankedTeam::where("region", "=", $region)->where("tag", "=", $tag)->first();
        if(isset($ranked_team["id"]) && $ranked_team["id"] > 0){
            return View::make("teams.detail", array(
                "ranked_team" => $ranked_team,
            ));
        }
        return View::make("teams.not_found");
    }

    public function updateTeam($team_id){
        $ranked_team = RankedTeam::where("id", "=", $team_id)->first();
        if($ranked_team->id && $ranked_team->id > 0){
            $need_api_request = true;
            $date1   = date('Y-m-d H:i:s');
            $date2   = $ranked_team->last_update_main_data;
            $diff    = abs(strtotime($date2) - strtotime($date1));
            $mins    = floor($diff / 60);

            if($mins < 60){
                $need_api_request = false;
            }

            if($need_api_request){
                $update = RankedTeam::update_team($ranked_team->team_id, $ranked_team->region);
                if($update){
                    $ranked_team->last_update_main_data = date('Y-m-d H:i:s');
                    $ranked_team->save();
                    echo "success";
                } else {
                    echo "error";
                }
            } else {
                echo "no_update_needet";
            }
        } else {
            echo "error";
        }
    }

    public function settings($region, $tag){
        $region = trim($region);
        $tag    = trim($tag);
        $ranked_team = RankedTeam::where("region", "=", $region)->where("tag", "=", $tag)->first();
        if(isset($ranked_team["id"]) && $ranked_team["id"] > 0 && Auth::check() && $ranked_team["leader_summoner_id"] == Auth::user()->summoner->summoner_id){
            return View::make("teams.settings", array(
                "ranked_team" => $ranked_team,
            ));
        }
        return View::make("teams.not_found");
    }

    public function settings_post(){
        $ranked_team = RankedTeam::where("id", "=", Input::get("id"))->first();
        if(isset($ranked_team["id"]) && $ranked_team["id"] > 0 && Auth::check() && $ranked_team["leader_summoner_id"] == Auth::user()->summoner->summoner_id){
            if(Input::get('looking_for') && Input::get('looking_for') == "true"){
                $ranked_team->looking_for_players = 1;
            } else {
                $ranked_team->looking_for_players = 0;
            }

            if(Input::get('looking_in_league')){
                $ranked_team->looking_in_league = trim(Input::get('looking_in_league'));
            }
            if(Input::get('looking_in_league_sec')){
                $ranked_team->looking_in_league_second = trim(Input::get('looking_in_league_sec'));
            }

            if(Input::get('looking_adc') && Input::get('looking_adc') == "true"){
                $ranked_team->looking_for_adc = 1;
            } else {
                $ranked_team->looking_for_adc = 0;
            }
            if(Input::get("looking_adc_info")){
                $ranked_team->looking_for_adc_desc = trim(Input::get("looking_adc_info"));
            }

            if(Input::get('looking_support') && Input::get('looking_support') == "true"){
                $ranked_team->looking_for_support = 1;
            } else {
                $ranked_team->looking_for_support = 0;
            }
            if(Input::get("looking_support_info")){
                $ranked_team->looking_for_support_desc = trim(Input::get("looking_support_info"));
            }

            if(Input::get('looking_jungle') && Input::get('looking_jungle') == "true"){
                $ranked_team->looking_for_jungle = 1;
            } else {
                $ranked_team->looking_for_jungle = 0;
            }
            if(Input::get("looking_jungle_info")){
                $ranked_team->looking_for_jungle_desc = trim(Input::get("looking_jungle_info"));
            }

            if(Input::get('looking_top') && Input::get('looking_top') == "true"){
                $ranked_team->looking_for_top = 1;
            } else {
                $ranked_team->looking_for_top = 0;
            }
            if(Input::get("looking_top_info")){
                $ranked_team->looking_for_top_desc = trim(Input::get("looking_top_info"));
            }

            if(Input::get('looking_mid') && Input::get('looking_mid') == "true"){
                $ranked_team->looking_for_mid = 1;
            } else {
                $ranked_team->looking_for_mid = 0;
            }
            if(Input::get("looking_mid_info")){
                $ranked_team->looking_for_mid_desc = trim(Input::get("looking_mid_info"));
            }

            if(Input::get("looking_language")){
                $ranked_team->looking_for_lang = trim(Input::get("looking_language"));
            }

            if(Input::get("description")){
                $ranked_team->description = trim(Input::get("description"));
            }
            /*if(Input::get("looking_language_sec")){ // Zweite Sprache deaktiviert
                $ranked_team->looking_for_lang_second = trim(Input::get("looking_language_sec"));
            }*/
            $ranked_team->save();

            return Redirect::to('/teams/'.$ranked_team->region."/".$ranked_team->tag."/settings");
        }
        return View::make("teams.not_found");
    }
    
	public function add(){
		return View::make("teams.add");
	}
	
	public function add_post(){
        if(Auth::check()){
            if(Input::get("ranked_team_id") && trim(Input::get("ranked_team_id")) != ""){
                $region       = Auth::user()->summoner->region;
                $check        = true;
                $check_object = RankedTeam::where("team_id", "=", trim(Input::get("ranked_team_id")))->where("region", "=", $region)->first();
                if(isset($check_object["id"]) && $check_object["id"] > 0){
                    $check = false;
                }

                if($check){
                    $ranked_team = RankedTeam::update_team(trim(Input::get("ranked_team_id")), $region, true);
                    if($ranked_team){
                        echo json_encode(array("status" => "success", "data" => $ranked_team->id));
                    } else {
                        echo "error";
                    }
                } else {
                    echo "already_added";
                }
            } else {
                echo "error";
            }
        } else {
            echo "error";
        }
	}

    public function add_success($id){
        if(Auth::check()){
            $ranked_team = RankedTeam::where("id", "=", $id)->first();
            if(isset($ranked_team->id) && $ranked_team->id > 0 && $ranked_team->leader_summoner_id == Auth::user()->summoner->summoner_id){
                return View::make("teams.add_success", array(
                    "ranked_team" => $ranked_team
                ));
            }
        }
        return View::make("teams.not_found");
    }
	
	public function getLoggedRankedTeams(){
        if(Auth::check()){
            $api_key     = Config::get('api.key');
            $summoner_id = Auth::user()->summoner->summoner_id;
            $region      = Auth::user()->summoner->region;
            if(isset($summoner_id) && $summoner_id > 0){
                $content = @file_get_contents("https://".trim($region).".api.pvp.net/api/lol/".trim($region)."/v2.4/team/by-summoner/".trim($summoner_id)."?api_key=".trim($api_key));
                $json    = json_decode($content, true);
                
                if(isset($json[$summoner_id])){
                    $return_arr = array();
                    foreach($json[$summoner_id] as $team){
                        $array                   = array();
                        $array["id"]             = $team["fullId"];
                        $array["name"]           = $team["name"];
                        $array["tag"]            = $team["tag"];
                        $array["status"]         = $team["status"];
                        $array["date_create"]    = $team["createDate"];
                        if(isset($team["lastJoinDate"])){
                            $array["date_last_join"] = $team["lastJoinDate"];
                        }
                        if(isset($team["lastGameDate"])){
                            $array["date_last_game"] = $team["lastGameDate"];
                        }
                        
                        $array["ranked_5"] = array("wins" => 0, "losses" => 0, "average_games_played" => 0);
                        $array["ranked_3"] = array("wins" => 0, "losses" => 0, "average_games_played" => 0);
                        foreach($team["teamStatDetails"] as $stats){
                            $type = "ranked_5";
                            if($stats["teamStatType"] == "RANKED_TEAM_3x3"){
                                $type = "ranked_3";
                            }
                            $array[$type] = array("wins" => $stats["wins"], "losses" => $stats["losses"], "average_games_played" => $stats["averageGamesPlayed"]);
                        }
                        
                        $check = true;
                        $ranked_team_check = RankedTeam::where("team_id", "=", $team["fullId"])->first();
                        if(isset($ranked_team_check) && isset($ranked_team_check["id"]) && $ranked_team_check["id"] > 0){
                            $check = false;
                        }
                        
                        $array["is_lead"] = false;
                        if(isset($team["roster"]) && isset($team["roster"]["ownerId"]) && $team["roster"]["ownerId"] == $summoner_id && $check){
                            $array["is_lead"] = true;
                        }
                        $return_arr[$team["fullId"]] = $array;
                    }
                    echo json_encode($return_arr);
                } else {
                    echo "no_ranked_teams_found";
                }
            } else {
                echo "error";
            }
        } else {
            echo "error";
        }
	}
	
	public function apply_lightbox(){
        if(Input::get("team")){
            $ranked_team = RankedTeam::where("id", "=", Input::get("team"))->first();
            if($ranked_team && $ranked_team->id > 0){
                return View::make("teams.apply.lightbox_start", array(
                    "ranked_team" => $ranked_team
                ));
            }
        }
        echo "error";
    }
    
    public function apply_lightbox_post(){
        if(Input::get("team") && Auth::check()){
           if(RankedTeam::loggedCanApplyToTeam(Input::get("team")) == "can_apply"){
                $ranked_team = RankedTeam::where("id", "=", Input::get("team"))->first();

                if($ranked_team && isset($ranked_team["id"]) && $ranked_team["id"] > 0){
                    $leader      = User::where("summoner_id", "=", $ranked_team["leader_summoner_id"])->first();

                    if($leader && isset($leader["id"]) && $leader["id"] > 0){
                        $apply        = new RankedTeamApplication();
                        $apply->team  = $ranked_team["id"];
                        $apply->user  = Auth::user()->id;
                        $apply->role  = Input::get("role");
                        
                        if(Input::get("comment") && trim(Input::get("comment")) != ""){
                           $apply->comment = trim(Input::get("comment"));
                        }
                        $apply->save();

                        // Notification an Team-Leiter senden
                        FIServer::add_notification($leader["id"], "team_application", Auth::user()->id, $apply->id, $ranked_team["id"]);
                        echo "success";
                    } else {
                        echo "error";
                    }
                } else {
                    echo "error";
                }
           } else {
               echo "error";
           }
        } else {
           echo "error";
        }
    }

    public function applications($region, $tag){
        $ranked_team = RankedTeam::where("region", "=", $region)->where("tag", "=", $tag)->first();
        if(isset($ranked_team["id"]) && $ranked_team["id"] > 0){
            if(Auth::check() && $ranked_team->leader_summoner_id == Auth::user()->summoner->summoner_id){
                return View::make("teams.applications", array(
                    "ranked_team"  => $ranked_team,
                    "applications" => RankedTeamApplication::where("team", "=", $ranked_team->id)->get(),
                ));
            }
        }
        return View::make("teams.not_found");
    }

    public function application_detail($region, $tag, $id){
        $ranked_team = RankedTeam::where("region", "=", $region)->where("tag", "=", $tag)->first();
        $application = RankedTeamApplication::where("id", "=", $id)->first();
        if(isset($ranked_team["id"]) && $ranked_team["id"] > 0 && isset($application["id"]) && $application["id"] > 0){
            if(Auth::check() && $ranked_team->leader_summoner_id == Auth::user()->summoner->summoner_id){
                return View::make("teams.application_detail", array(
                    "ranked_team" => $ranked_team,
                    "user"        => Helpers::getUser($application["user"]),
                    "application" => $application,
                ));
            }
        }
        return View::make("teams.not_found");
    }

    public function application_delete($region, $tag, $id){
        $ranked_team = RankedTeam::where("region", "=", $region)->where("tag", "=", $tag)->first();
        $application = RankedTeamApplication::where("id", "=", $id)->first();
        if(isset($ranked_team["id"]) && $ranked_team["id"] > 0 && isset($application["id"]) && $application["id"] > 0){
            if(Auth::check() && $ranked_team->leader_summoner_id == Auth::user()->summoner->summoner_id){
                // Notification an Team-Leiter senden
                FIServer::add_notification($application["user"], "team_application_delete", $ranked_team["id"]);

                $application->delete();
                return Redirect::to('/teams/'.$ranked_team->region."/".$ranked_team->tag."/applications");
            }
        }
        return View::make("teams.not_found");
    }
}
