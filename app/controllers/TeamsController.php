<?php

class TeamsController extends \BaseController {
    public function index(){
        $own_teams    = array();
        if(Auth::check()){
            $teams_player = RankedTeamPlayer::where("summoner_id", "=", Auth::user()->summoner->summoner_id)->get();
            foreach($teams_player as $player){
                $ranked_team_temp = RankedTeam::where("id", "=", $player->team)->first();
                if(isset($ranked_team_temp) && $ranked_team_temp && $ranked_team_temp->id > 0){
                    $own_teams[] = $ranked_team_temp;
                }
            }
        }
        return View::make("teams.index", array(
            "own_teams" => $own_teams
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
    
	public function add(){
		return View::make("teams.add");
	}
	
	public function add_post(){
        if(Auth::check()){
            if(Input::get("ranked_team_id") && trim(Input::get("ranked_team_id")) != ""){
                $api_key = Config::get('api.key');
                $region  = Auth::user()->summoner->region;
                $content = @file_get_contents("https://".trim($region).".api.pvp.net/api/lol/".trim($region)."/v2.4/team/".trim(Input::get("ranked_team_id"))."?api_key=".trim($api_key));
                $json    = json_decode($content, true);
                
                if(isset($json[trim(Input::get("ranked_team_id"))]) && isset($json[trim(Input::get("ranked_team_id"))]["fullId"])){
                    $team         = $json[trim(Input::get("ranked_team_id"))];
                    $check        = true;
                    $check_object = RankedTeam::where("team_id", "=", $team["fullId"])->where("region", "=", $region)->first();
                    if(isset($check_object["id"]) && $check_object["id"] > 0){
                        $check = false;
                    }
                    if($check){
                        $ranked_team                     = new RankedTeam();
                        $ranked_team->region             = $region;
                        $ranked_team->team_id            = $team["fullId"];
                        $ranked_team->name               = $team["name"];
                        $ranked_team->tag                = $team["tag"];
                        $ranked_team->adder_summoner_id  = Auth::user()->summoner->summoner_id;
                        $ranked_team->leader_summoner_id = $team["roster"]["ownerId"];
                        $ranked_team->save();
                        
                        // Spieler des Ranked-Teams Speichern
                        foreach($team["roster"]["memberList"] as $player){
                            if(isset($player["playerId"])){
                                $summoner_temp = Summoner::update_summoner($player["playerId"], $region);
                                if($summoner_temp && $summoner_temp->summoner_id > 0){
                                    $check = RankedTeamPlayer::where("summoner_id", "=", $summoner_temp->summoner_id)->where("team", "=", $ranked_team->id)->first();
                                    
                                    if(isset($check) && $check && isset($check["id"]) && $check["id"] > 0){
                                        // Aus irgendeinem Grund gibt es in der DB wohl schon die Kombination aus Summoner-ID und diesem Team -> also nichts machen
                                    } else {
                                        $ranked_team_player = new RankedTeamPlayer;
                                        $ranked_team_player->team = $ranked_team->id;
                                        $ranked_team_player->summoner_id = $summoner_temp->summoner_id;
                                        $ranked_team_player->save();
                                    }
                                }
                            }
                        }
                        
                        echo json_encode(array("status" => "success", "data" => $ranked_team->id));
                    } else {
                        echo "already_added";
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