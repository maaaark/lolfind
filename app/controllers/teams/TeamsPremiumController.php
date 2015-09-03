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
            	"ranked_team"	=> $team,
        	))->render();
		} else {
			echo "error";
		}
	}

	public function calendar_day_lightbox($region, $tag){
		$team = RankedTeam::where("region", "=", $region)->where("tag", "=", $tag)->first();
		if(isset($team->id) && $team->id > 0 && Auth::check() && TeamPremiumCheck::hasPremium($team) && TeamPremiumCheck::user_is_in_team(Auth::user()->id, $team) && Input::get("date")){
			$events = RankedTeamCalendarEvent::where("team", "=", $team->id)->where("date", "=", trim(Input::get("date")))->orderBy("begin", "ASC")->get();

			echo View::make("teams.premium_features.lightbox_day", array(
				"date"			=> Input::get("date"),
				"ranked_team"	=> $team,
        		"events" 		=> $events,
        	))->render();
		} else {
			echo "error";
		}
	}

	public function calendar_day_lightbox_add($region, $tag){
		$team = RankedTeam::where("region", "=", $region)->where("tag", "=", $tag)->first();
		if(isset($team->id) && $team->id > 0 && Auth::check() && TeamPremiumCheck::hasPremium($team) && TeamPremiumCheck::user_is_in_team(Auth::user()->id, $team) && Input::get("date")){
			if(Input::get("date") && Input::get("name") && Input::get("type")){
				$event = new RankedTeamCalendarEvent;
				$event->date 		= trim(Input::get("date"));
				$event->team 		= $team->id;
				$event->user 		= Auth::user()->id;
				$event->name 		= trim(Input::get("name"));
				$event->event_type 	= trim(Input::get("type"));
				$event->begin       = date("Y-m-d H:i:s", strtotime(Input::get("date")." ".Input::get("begin_hour").":".Input::get("begin_minute")));
				$event->end         = date("Y-m-d H:i:s", strtotime(Input::get("date")." ".Input::get("end_hour").":".Input::get("end_minute")));
				if(Input::get("description")){
					$event->description = trim(Input::get("description"));
				}
				$event->save();
				echo "success";
			} else {
				echo "error";
			}
		} else {
			echo "error";
		}
	}

	public function calendar_day_lightbox_event($region, $tag){
		$team = RankedTeam::where("region", "=", $region)->where("tag", "=", $tag)->first();
		if(isset($team->id) && $team->id > 0 && Auth::check() && TeamPremiumCheck::hasPremium($team) && TeamPremiumCheck::user_is_in_team(Auth::user()->id, $team) && Input::get("event")){
			$event = RankedTeamCalendarEvent::where("id", "=", Input::get("event"))->first();
			if(isset($event->id) && $event->id > 0 && $team->id == $event->team){
				echo View::make("teams.premium_features.lightbox_event", array(
					"ranked_team" => $team,
					"event"		  => $event,
				))->render();
			} else {
				echo "error";
			}
		} else {
			echo "error";
		}
	}
}