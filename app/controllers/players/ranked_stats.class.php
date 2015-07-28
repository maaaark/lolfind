<?php

class RankedStatsView {
	private $current_season = "SEASON2015";
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
				$date2   = $summoner["last_update_ranked_stats"];
				$diff    = abs(strtotime($date2) - strtotime($date1));
				$mins    = floor($diff / 60);

				if($mins < $this->summoner_update_interval){
					$need_api_request = false;
				}

				if($need_api_request){
					$content = @file_get_contents($this->allowed_regions[$this->region]["api_endpoint"]."/api/lol/".$this->region."/v1.3/stats/by-summoner/".trim($summoner["summoner_id"])."/ranked?season=".$this->current_season."&api_key=".$api_key);
					$summoner->ranked_stats = $content;
					$summoner->last_update_ranked_stats = date("Y-m-d H:i:s");
					$summoner->save();
					$updated = true;
				} else {
					$content = $summoner["ranked_stats"];
				}

				if($content !== FALSE){
					$json = json_decode($content, true);

					if(isset($json["champions"]) && is_array($json["champions"])){
						$out 	   = array();
						$sort      = array();
					    foreach($json["champions"] as $champion){
							if(isset($champion["stats"]["totalSessionsPlayed"]) && isset($champion["id"]) && $champion["id"] > 0){
								$champ = Champion::where("champion_id", "=", $champion["id"])->first();

								$temp = array();
								$temp["championId"] 		   = $champion["id"];
								$temp["championName"]		   = $champ["name"];
								$temp["championKey"]		   = $champ["key"];
								$temp["totalSessionsPlayed"]   = $champion["stats"]["totalSessionsPlayed"];
								$temp["totalSessionsLost"]     = $champion["stats"]["totalSessionsLost"];
								$temp["totalSessionsWon"]      = $champion["stats"]["totalSessionsWon"];
								$temp["totalChampionKills"]    = $champion["stats"]["totalChampionKills"];
								$temp["maxChampionsKilled"]    = $champion["stats"]["maxChampionsKilled"];
								$temp["totalMinionKills"]      = $champion["stats"]["totalMinionKills"];
								$temp["totalGoldEarned"]       = $champion["stats"]["totalGoldEarned"];
								$temp["totalTurretsKilled"]    = $champion["stats"]["totalTurretsKilled"];
								$temp["totalAssists"]		   = $champion["stats"]["totalAssists"];
								$temp["maxNumDeaths"]		   = $champion["stats"]["maxNumDeaths"];
								$temp["totalDeathsPerSession"] = $champion["stats"]["totalDeathsPerSession"];
								$out[]  	 = $temp;
								$sort[] = $champion["stats"]["totalSessionsWon"];
							}
						}
						array_multisort($sort, $out);
						$out = array_reverse($out);

						return array("updated" => $updated, "template" => json_encode($out));
					} else {
						return array("updated" => $updated, "template" => "error");
					}
				} else {
					return array("updated" => $updated, "template" => "error");
				}
			}
		}
		return array("updated" => $updated, "template" => "error");
	}
}
?>