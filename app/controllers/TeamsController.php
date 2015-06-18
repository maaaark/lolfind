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

        /*
        $team_list_view = false;
        if($league1 && $league2){
            $team_list = RankedTeam::where("ranked_league_5", "LIKE", "%".trim($league1)."%")
                                   ->where("looking_for_players", "=", 1)
                                   ->orWhere("ranked_league_5", "LIKE", "%".trim($league2)."%")
                                   ->where("looking_for_players", "=", 1)
                                   ->take($this->list_suggestion_limit)
                                   ->get();
            $team_list_view = View::make("teams.suggestion_list", array(
               "ranked_teams" => $team_list
            ));
        } elseif($league1){
            if(strtolower(trim($league1)) == "diamond+"){
               $team_list = RankedTeam::where("ranked_league_5", "LIKE", "%diamond%")
                                   ->where("looking_for_players", "=", 1)
                                   ->orWhere("ranked_league_5", "LIKE", "%master%")
                                   ->where("looking_for_players", "=", 1)
                                   ->orWhere("ranked_league_5", "LIKE", "%challenger%")
                                   ->where("looking_for_players", "=", 1)
                                   ->take($this->list_suggestion_limit)
                                   ->get();
               $team_list_view = View::make("teams.suggestion_list", array(
                  "ranked_teams" => $team_list
               ));
            } else {
               $team_list = RankedTeam::where("ranked_league_5", "LIKE", "%".trim($league1)."%")
                                   ->where("looking_for_players", "=", 1)
                                   ->take($this->list_suggestion_limit)
                                   ->get();
               $team_list_view = View::make("teams.suggestion_list", array(
                  "ranked_teams" => $team_list
               ));
            }
        }


        return View::make("teams.index", array(
            "own_teams" => $own_teams,
            "team_list" => $team_list_view,
        ));

        */
        $team_list = RankedTeam::all();

        return View::make('teams.index', compact('team_list', 'own_teams'));
    }

    public function list_suggestions(){



        /*
        $region = "euw";
        if(Input::get("region")){
            $region = trim(Input::get("region"));
        }

        $league = "gold";
        if(Input::get("league")){
            $league = trim(Input::get("league"));
        }

        $main_lang = "english";
        if(Input::get("main_lang")){
            $main_lang = trim(Input::get("main_lang"));
        }

        $sec_lang      = "english";
        if(Input::get("sec_lang")){
            $sec_lang = trim(Input::get("sec_lang"));
        }

        $prime_role = "adc";
        if(Input::get("prime_role")){
            $prime_role = trim(Input::get("prime_role"));
        }

        $sec_role = "support";
        if(Input::get("sec_role")){
            $sec_role = trim(Input::get("sec_role"));
        }
        
        $league = "gold";
        if(Input::get("league")){
            $league = trim(Input::get("league"));
        }
        
        // Aktuelle Liga muss noch hinzugefügt werden
        // SQL-Generieren
        $sql = "SELECT * FROM ranked_team WHERE";
        $sql_arr = array();

        $sql .= ' region = :region';
        $sql_arr["region"] = "euw";
        
        $sql .= ' AND looking_for_players = 1';

        if($sec_lang == "no_value" || $sec_lang == $main_lang){
            $sql                 .= " AND looking_for_lang = :main_lang";
            $sql_arr["main_lang"] = $main_lang;
        } else {
            $sql                 .= " AND looking_for_lang IN (:main_lang, :sec_lang)";
            $sql_arr["main_lang"] = $main_lang;
            $sql_arr["sec_lang"]  = $sec_lang;
        }

        if($sec_role == "no_value" || $sec_role == $prime_role){
            $sql                 .= " AND looking_for_".$prime_role." = 1";
        } else {
            $sql                 .= " AND looking_for_".$prime_role." = 1";

            $sql                 .= " OR looking_for_".$sec_role." = 1";
            $sql                 .= ' AND region = :region2';
            $sql_arr["region2"] = "euw";
            
            $sql .= ' AND looking_for_players = 1';
            
            if($sec_lang == "no_value" || $sec_lang == $main_lang){
                $sql                 .= " AND looking_for_lang = :main_lang2";
                $sql_arr["main_lang2"] = $main_lang;
            } else {
                $sql                 .= " AND looking_for_lang IN (:main_lang2, :sec_lang2)";
                $sql_arr["main_lang2"] = $main_lang;
                $sql_arr["sec_lang2"]  = $sec_lang;
            }
        }
        $sql .= ' LIMIT '.intval($this->list_suggestion_limit);

        */

        print_r(Input::all());


        //$ranked_teams = DB::select(DB::raw($sql), $sql_arr);
        $ranked_teams = RankedTeam::where("name","!=", "");
        $ranked_teams->where('looking_for_players',"=",1);

        if(Input::get("league") != "any") {
            $ranked_teams->where('ranked_league_5',"LIKE", '%'.Input::get("league").'%');
        }

        if(Input::get("region") != "any") {
            $ranked_teams->where('region',"=",Input::get("region"));
        }

        if(Input::get("search_unranked") != null) {
            // 1 = bronze
            $ranked_teams->where('league_prediction',"=",1);
        }

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

        $ranked_teams = $ranked_teams->get();

        return View::make("teams.suggestion_list", array(
            "ranked_teams" => $ranked_teams
        ));
    }
    
    public function detail($region, $tag){
        $region = trim($region);
        $tag    = trim($tag);
        $ranked_team = RankedTeam::where("region", "=", $region)->where("tag", "=", $tag)->first();
        if(isset($ranked_team["id"]) && $ranked_team["id"] > 0){
            return View::make("teams.detail", array(
                "ranked_team" => $ranked_team,
            ));
        }
        return View::make("teams.not_found");
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
                    $ranked_team = RankedTeam::update_team(trim(Input::get("ranked_team_id")), $region);
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
}