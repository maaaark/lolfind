<?php

class MatchhistoryView {
	private $allowed_regions, $region, $summoner_update_interval;

	public function __construct($regions, $region, $summoner_update_interval){
		$this->allowed_regions 			= $regions;
		$this->region 		   		    = $region;
		$this->summoner_update_interval = $summoner_update_interval;
	}

	public function show($sID = false){
		if($sID){
			$updated  = false;
			$api_key  = Config::get('api.key');
			$summoner = Summoner::where('summoner_id', '=', trim($sID))->first();

			if(isset($summoner["id"]) && $summoner["id"] > 0){
				$need_api_request = true;
				$date1   = date('Y-m-d H:i:s');
				$date2   = $summoner["last_update_matchhistory"];
				$diff    = abs(strtotime($date2) - strtotime($date1));
				$mins    = floor($diff / 60);

				if($mins < $this->summoner_update_interval){
					$need_api_request = false;
				}

				if($need_api_request){
					$content = @file_get_contents($this->allowed_regions[$this->region]["api_endpoint"]."/api/lol/".$this->region."/v1.3/game/by-summoner/".trim($summoner["summoner_id"])."/recent?api_key=".$api_key);
					if($content !== FALSE){
						$json = json_decode($content, true);
						if(isset($json["games"][0]) && is_array($json["games"])){
							$games  = json_encode($json["games"]);
							$summoner->matchhistory = $games;
							$summoner->last_update_matchhistory = date('Y-m-d H:i:s');
							$summoner->save();
							$updated = true;
						}
					}
				}

				if(isset($summoner->matchhistory) && trim($summoner->matchhistory) != ""){
					$matchhistory_orig = json_decode($summoner->matchhistory, true);
					$region_name 	   = $this->allowed_regions[$this->region]["name"];
					$template          = "";

					$count = 0;
					foreach($matchhistory_orig as $game){
						if($count == 0){
							$last_champ = Champion::where('champion_id', '=', trim($game["championId"]))->first();
							$summoner->lastchamp = $last_champ["key"];
							$summoner->save();
						}
						$template .= $this->handleMatch($game, $summoner, $count);
						$count++;
					}
					return array("updated" => $updated, "template" => $template);
				} else {
					return array("updated" => $updated, "template" => "Matchhistory konnte nicht geladen werden.");
				}
			} else {
				return array("updated" => $updated, "template" => "Summoner not found");
			}
		} else {
			return array("updated" => $updated, "template" => "Summoner not found");
		}
	}

	private function handleMatch($game, $summoner, $count){
		$api_key = Config::get('api.key');

		$champion = Champion::where('champion_id', '=', trim($game["championId"]))->first();
		$game["items"] = array(0 => false, 1 => false, 2 => false, 3 => false, 4 => false, 5 => false, 6 => false);
		foreach($game["stats"] as $column => $value){
			if(strpos("platzhalter_".$column, "item") > 0){
				if($value > 0){
					$temp = Item::where('item_id', '=', $value)->first();
					$game["items"][intval(str_replace("item", "", $column))] = $temp;
				} else {
					$game["items"][intval(str_replace("item", "", $column))] = false;
				}
			}
		}

		$team1 = array();
		$team2 = array();
		if(isset($game["fellowPlayers"])){
			$summoner_ids = "";
			$summoner_data = array();
			foreach($game["fellowPlayers"] as $player){
				$check = Summoner::where("summoner_id", "=", $player["summonerId"])->first();

				if(isset($check["id"]) && $check["id"] > 0){
					$temp = array();
					$temp["id"] 		   = $check["summonerId"];
					$temp["name"] 		   = $check["name"];
					$temp["profileIconId"] = $check["profileIconId"];
					$temp["summonerLevel"] = $check["summonerLevel"];
					$temp["revisionDate"]  = $check["revisionDate"];
					$summoner_data[$player["summonerId"]] = $temp;
				} else {
					$summoner_ids .= $player["summonerId"].",";
				}
			}

			if(trim(str_replace(",", "", $summoner_ids)) != ""){
				$summoner_data_api = @file_get_contents($this->allowed_regions[$this->region]["api_endpoint"]."/api/lol/euw/v1.4/summoner/".trim($summoner_ids)."?api_key=".$api_key);
				$summoner_data_api = json_decode($summoner_data_api, true);
				foreach($summoner_data_api as $summoner_id => $summoner_player){
					//print_r($summoner_player);
					$temp = $summoner_player;
					$summoner_data[$summoner_player["id"]] = $temp;

					$new_summoner 					= new Summoner;
					$new_summoner->region 			= $this->region;
					$new_summoner->summoner_id 		= $summoner_player["id"];
					$new_summoner->name 			= $summoner_player["name"];
					$new_summoner->profileIconId 	= $summoner_player["profileIconId"];
					$new_summoner->summonerLevel 	= $summoner_player["summonerLevel"];
					$new_summoner->revisionDate 	= $summoner_player["revisionDate"];
					$new_summoner->save();
				}
			}

			foreach($game["fellowPlayers"] as $player){
				if(isset($summoner_data[$player["summonerId"]])){
					$element = $summoner_data[$player["summonerId"]];
					$temp = array();
					$temp["name"]  	  = $element["name"];
					$temp["champion"] = Champion::where('champion_id', '=', trim($player["championId"]))->first();

					if($player["teamId"] == 100){
						$team1[] = $temp;
					} else {
						$team2[] = $temp;
					}
				}
			}
		}

		return View::make('users.lol_data.matchhistory', [
					'game' 	   => $game,
					'champion' => $champion,
					'team1'	   => $team1,
					'team2'	   => $team2,
					'summoner' => $summoner,
					'count'	   => $count
				])->render(); 
	}
}