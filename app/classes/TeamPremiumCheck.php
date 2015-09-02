<?php

class TeamPremiumCheck {

	public static function user_is_in_team($user_id, $team){
		if(Auth::check()){
			$check = RankedTeamPlayer::where("team", "=", $team->id)->where("summoner_id", "=", Auth::user()->summoner_id)->first();
			if(isset($check->id) && $check->id > 0){
				return true;
			}
		}
		return false;
	}

	public static function user_is_team_leader($user_id, $team){
		$user = User::where("id", "=", $user_id)->first();
		if(isset($user->id) && $user->id > 0){
			if($user->summoner_id > 100 && $user->summoner_id == $team->leader_summoner_id){
				return true;
			}
		}
		return false;
	}

	public static function hasPremium($team){
		$user = User::where("id", "=", Helpers::get_userid_by_summoner($team->leader_summoner_id, $team->region))->first();
		if(isset($user->id) && $user->id > 0){
			if($user->hasRole("admin")){
				return true;
			}
		}
		return false;
	}

	public static function can_change_config_rights($user_id, $team){
		if(TeamPremiumCheck::user_is_in_team($user_id, $team)){
			if(TeamPremiumCheck::user_is_team_leader($user_id, $team)){ // Wenn Team-Leader
				return true;
			}
			else { // Hier checken ob manuel für dieses Setting freigeschaltet wurde
				$summoner = Helpers::get_summoner_by_userid($user_id);
				if($summoner){
					$ranked_team_player = RankedTeamPlayer::where("team", "=", $team->id)->where("summoner_id", "=", $summoner->summoner_id)->first();
					if(isset($ranked_team_player->id) && $ranked_team_player->id > 0){
						$permissions = @json_decode($ranked_team_player->permissions, true);
						if(isset($permissions) && $permissions && is_array($permissions)){
							if(isset($permissions["permissions"]) && $permissions["permissions"]){
								return true;
							}
						}
					}
				}
			}
		}
		return false;
	}

	public static function can_manage_forums($user_id, $team){
		if(TeamPremiumCheck::user_is_in_team($user_id, $team)){
			if(TeamPremiumCheck::user_is_team_leader($user_id, $team)){ // Wenn Team-Leader
				return true;
			}
			else { // Hier checken ob manuel für dieses Setting freigeschaltet wurde
				$summoner = Helpers::get_summoner_by_userid($user_id);
				if($summoner){
					$ranked_team_player = RankedTeamPlayer::where("team", "=", $team->id)->where("summoner_id", "=", $summoner->summoner_id)->first();
					if(isset($ranked_team_player->id) && $ranked_team_player->id > 0){
						$permissions = @json_decode($ranked_team_player->permissions, true);
						if(isset($permissions) && $permissions && is_array($permissions)){
							if(isset($permissions["forums"]) && $permissions["forums"]){
								return true;
							}
						}
					}
				}
			}
		}
		return false;
	}

	public static function can_edit_calendar($user_id, $team){
		if(TeamPremiumCheck::user_is_in_team($user_id, $team)){
			if(TeamPremiumCheck::user_is_team_leader($user_id, $team)){ // Wenn Team-Leader
				return true;
			}
			else { // Hier checken ob manuel für dieses Setting freigeschaltet wurde
				$summoner = Helpers::get_summoner_by_userid($user_id);
				if($summoner){
					$ranked_team_player = RankedTeamPlayer::where("team", "=", $team->id)->where("summoner_id", "=", $summoner->summoner_id)->first();
					if(isset($ranked_team_player->id) && $ranked_team_player->id > 0){
						$permissions = @json_decode($ranked_team_player->permissions, true);
						if(isset($permissions) && $permissions && is_array($permissions)){
							if(isset($permissions["calendar"]) && $permissions["calendar"]){
								return true;
							}
						}
					}
				}
			}
		}
		return false;
	}
}