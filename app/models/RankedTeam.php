<?php

class RankedTeam extends \Eloquent {
    protected $table = 'ranked_team';
    
    public function player()
    {
        return $this->hasMany('RankedTeamPlayer', 'team_id', "team_internal_id");
    }

    public function players()
    {
        return $this->hasMany('RankedTeamPlayer', 'team_id', "team_internal_id");
    }

    public static function update_team($full_team_id, $region){
    	$api_key = Config::get('api.key');
        $content = @file_get_contents("https://".trim($region).".api.pvp.net/api/lol/".trim($region)."/v2.4/team/".trim($full_team_id)."?api_key=".trim($api_key));
        $json    = json_decode($content, true);
        
        if(isset($json[trim($full_team_id)]) && isset($json[trim($full_team_id)]["fullId"])){
            $team         = $json[trim($full_team_id)];

            $check_object = RankedTeam::where("team_id", "=", $team["fullId"])->where("region", "=", $region)->first();
            if(isset($check_object["id"]) && $check_object["id"] > 0){
            	$ranked_team = $check_object;
        	} else {
	            $ranked_team                     = new RankedTeam();
	            $ranked_team->region             = $region;
	            $ranked_team->team_id            = $team["fullId"];
        	}
            $ranked_team->name               = $team["name"];
            $ranked_team->tag                = $team["tag"];
            $ranked_team->adder_summoner_id  = Auth::user()->summoner->summoner_id;
            $ranked_team->leader_summoner_id = $team["roster"]["ownerId"];
            
            // Liga-Platzierung laden
            $league_5       = "bronze";
            $league_content = @file_get_contents("https://".trim($region).".api.pvp.net/api/lol/".trim($region)."/v2.5/league/by-team/".trim($team["fullId"])."/entry?api_key=".trim($api_key));
            $league_json    = json_decode($league_content, true);
            if(isset($league_json[$team["fullId"]]) && isset($league_json[$team["fullId"]][0]) && is_array($league_json[$team["fullId"]])){
                foreach($league_json[$team["fullId"]] as $entry){
                    if(isset($entry["queue"]) && isset($entry["tier"]) && isset($entry["entries"]) && is_array($entry["entries"]) && isset($entry["entries"][0])){
	              		if(isset($entry["entries"][0]["division"]) && isset($entry["entries"][0]["leaguePoints"]) && isset($entry["entries"][0]["wins"]) && isset($entry["entries"][0]["losses"])){
							if(trim($entry["queue"]) == "RANKED_TEAM_5x5"){
							    $ranked_team->ranked_league_5 = strtolower(trim($entry["tier"]))."_".$entry["entries"][0]["division"];
							    $ranked_team->ranked_league_5_wins = $entry["entries"][0]["wins"];
							    $ranked_team->ranked_league_5_losses = $entry["entries"][0]["losses"];
							    $ranked_team->ranked_league_5_league_points = $entry["entries"][0]["leaguePoints"];
							}
							elseif(trim($entry["queue"]) == "RANKED_TEAM_3x3"){
								$ranked_team->ranked_league_3 = strtolower(trim($entry["tier"]))."_".$entry["entries"][0]["division"];
								$ranked_team->ranked_league_3_wins = $entry["entries"][0]["wins"];
								$ranked_team->ranked_league_3_losses = $entry["entries"][0]["losses"];
								$ranked_team->ranked_league_3_league_points = $entry["entries"][0]["leaguePoints"];
							}
						}
					}
                }
            }
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
            
            return $ranked_team;
        } else {
            return false;
        }
    }
}