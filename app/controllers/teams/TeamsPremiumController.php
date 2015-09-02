<?php

class TeamsPremiumController extends \BaseController {

	public function config_rights($region, $tag){
		$team = RankedTeam::where("region", "=", $region)->where("tag", "=", $tag)->first();
		if(isset($team->id) && $team->id > 0 && Auth::check() && TeamPremiumCheck::hasPremium($team) && TeamPremiumCheck::can_change_config_rights(Auth::user()->id, $team)){
			return View::make("teams.premium_features.config_rights", array(
				"ranked_team" => $team,
			));
		}
		return App::abort("404");
	}

	public function config_rights_action($region, $tag){
		$team = RankedTeam::where("region", "=", $region)->where("tag", "=", $tag)->first();
		if(isset($team->id) && $team->id > 0 && Auth::check() && TeamPremiumCheck::hasPremium($team) && TeamPremiumCheck::can_change_config_rights(Auth::user()->id, $team)){
			$last_internal_id = false;
			$array			  = array();
			foreach(Input::all() as $input_name => $input){
				if(strpos(trim(strtolower($input_name)), "_user_internal") > 0){
					$last_internal_id = $input;
					$array[$last_internal_id] = array(
						"permissions"	=> false,
						"forums"		=> false,
						"calendar" 		=> false,
					);
					continue;
				}

				if($last_internal_id && $last_internal_id > 0){
					$type = trim(strtolower(substr(trim($input_name), strpos(trim($input_name), "-") + 1)));
					$internal_id = substr(trim($input_name), strpos(trim($input_name), "_") + 1, strpos(trim($input_name), "-") - strpos(trim($input_name), "_") - 1);

					if($internal_id == $last_internal_id){ // Kontrolle, ob das Formular auch stimmt
						if($type == "permissions"){
							$array[$last_internal_id]["permissions"] = true;
						}
						elseif($type == "forums"){
							$array[$last_internal_id]["forums"]	= true;
						}
						elseif($type == "calendar"){
							$array[$last_internal_id]["calendar"] = true;
						}
					}
				}
			}

			// Daten speichern
			foreach($array as $temp_summoner_internal => $arr){
				if($temp_summoner_internal > 0 && is_array($arr) && isset($arr["permissions"]) && isset($arr["forums"]) && isset($arr["calendar"])){
					$summoner = Summoner::where("id", "=", $temp_summoner_internal)->first();
					if(isset($summoner->id) && $summoner->id > 0){
						$ranked_team_player = RankedTeamPlayer::where("team", "=", $team->id)->where("summoner_id", "=", $summoner->summoner_id)->first();
						if(isset($ranked_team_player->id) && $ranked_team_player->id > 0){
							$ranked_team_player->permissions = json_encode($arr);
							$ranked_team_player->save();
						}
					}
				}
			}
			return Redirect::to("/teams/".$team->region."/".$team->tag."/settings/config-rights/")->with("success", "Successfully edited the team permissions.");
		}
		return App::abort("404");
	}

	public function calendar($region, $tag){
		$team = RankedTeam::where("region", "=", $region)->where("tag", "=", $tag)->first();
		if(isset($team->id) && $team->id > 0 && Auth::check() && TeamPremiumCheck::hasPremium($team) && TeamPremiumCheck::user_is_in_team(Auth::user()->id, $team)){
			return View::make("teams.premium_features.calendar", array(
				"ranked_team" => $team,
			));
		}
		return App::abort("404");
	}

	public function calendar_ajax($region, $tag, $month, $year){
		$team = RankedTeam::where("region", "=", $region)->where("tag", "=", $tag)->first();
		if(isset($team->id) && $team->id > 0 && Auth::check() && TeamPremiumCheck::hasPremium($team) && TeamPremiumCheck::user_is_in_team(Auth::user()->id, $team)){
			$days_count = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            echo View::make("teams.premium_features.calendar_ajax", array(
            	"days_count" 	=> $days_count,
            	"month"			=> $month,
            	"year"			=> $year,
        	))->render();
		} else {
			echo "error";
		}
	}

}