<?php
class Helpers {
    public static function diffForHumans($timestamp) {
    	if(is_string($timestamp)){
    		$created_timestamp = strtotime($timestamp);
    	} else {
			$created_timestamp = $timestamp->getTimestamp();
		}
		$current_timestamp = time();
		
		$timediff = $current_timestamp - $created_timestamp;
		
		$minutes = 60;			// 60
		$hours = 3600;		// 60 * 60
		$days = 86400;		// $minutes * 60
		$oneWeek = 604800; 	// $days * 7
		$twoWeek = 1209600; 	// $oneWeek + $oneWeek
		$normalDate = 1814400;
		
		if($timediff < $minutes) {
			$html = $timediff . " seconds ago";
		} else if ($timediff >= $minutes && $timediff < $hours) {
			//var_dump($timediff,round($timediff / $minutes));
			$outputTime = round($timediff / $minutes);
			$html = $outputTime . " minutes ago";
		} else if ($timediff >= $hours && $timediff < $days) {
			$outputTime = round($timediff / $hours);
			$html = $outputTime . " hours ago";
		} else if ($timediff >= $days && $timediff < $twoWeek) {
			$outputTime = round($timediff / $days);
			$html = $outputTime . " days ago";
		} else {
			$html = date("Y-m-d", $created_timestamp);
		}
        return $html;
    }

    public static function niceGameMode($gameMode) {
		if($gameMode == "CLASSIC") {
			$nice_gameMode = "Klassisch";
		} elseif($gameMode == "ODIN") {
			$nice_gameMode = "Dominion";
		} elseif($gameMode == "ARAM") {
			$nice_gameMode = "Aram";
		} else {
			$nice_gameMode = "Spezial Modus";
		}
        return $nice_gameMode;
    }

    public static function niceSubType($queueMode) {
		if($queueMode == "NONE") {
			$nice_queueMode = "Freies Spiel";
		} elseif($queueMode == "NORMAL") {
			$nice_queueMode = "Normales Spiel";
        } elseif($queueMode == "NORMAL_3x3") {
			$nice_queueMode = "Twisted Treeline";
        } elseif($queueMode == "ARAM_UNRANKED_5x5") {
			$nice_queueMode = "ARAM";
        } elseif($queueMode == "BOT ") {
			$nice_queueMode = "Bot Spiel";
        } elseif($queueMode == "RANKED_SOLO_5x5") {
			$nice_queueMode = "Solo Ranglisten Spiel";
        } elseif($queueMode == "RANKED_TEAM_3x3") {
			$nice_queueMode = "Team Ranglisten Spiel 3on3";
        } elseif($queueMode == "RANKED_TEAM_5x5") {
			$nice_queueMode = "Team Ranglisten Spiel 5on5";
        } elseif($queueMode == "URF") {
			$nice_queueMode = "Ultra Rapid Fire";
		} else {
			$nice_queueMode = "Anderer Spielmodus";
		}
        return $nice_queueMode;
    }

    public static function niceMatchMode($matchMode) {
		if($matchMode == "MATCHED_GAME") {
			$nice_matchMode = "Matched Game";
		} elseif($matchMode == "CUSTOM_GAME") {
			$nice_matchMode = "Freies Spiel";
		} else {
			$nice_matchMode = "Tutorial";
		}
        return $nice_matchMode;
    }

    public static function getUser($id){
    	$user = User::where("id", "=", $id)->first();
    	if(isset($user["id"]) && $user["id"] > 0){
    		return $user;
    	}
    	return false;
    }

    public static function getRankedTeam($id){
    	$team = RankedTeam::where("id", "=", $id)->first();
    	if(isset($team->id) && $team->id > 0){
    		return $team;
    	}
    	return false;
    }

    public static function getApplication($id){
    	$application = RankedTeamApplication::where("id", "=", $id)->first();
    	if(isset($application->id) && $application->id > 0){
    		return $application;
    	}
    	return false;
    }
    
    public static function getInvitation($id){
    	$invitation = RankedTeamInvitation::where("id", "=", $id)->first();
    	if(isset($invitation->id) && $invitation->id > 0){
    		return $invitation;
    	}
    	return false;
    }

    public static function get_summoner($summoner_id, $region = false){
    	if($region == false || trim($region) == ""){
    		$region = "euw";
    	}

    	return Summoner::where("summoner_id", "=", $summoner_id)->where("region", "=", $region)->first();
    }

	public static function niceLanguage($nice_lang) {
		if($nice_lang == "DE") {
			$nice_lang = "German";
		} elseif($nice_lang == "UK") {
			$nice_lang = "English";
		} elseif($nice_lang == "FR") {
			$nice_lang = "French";
		} elseif($nice_lang == "ES") {
			$nice_lang = "Spanish";
		} elseif($nice_lang == "IT ") {
			$nice_lang = "Italian";
		} elseif($nice_lang == "PL") {
			$nice_lang = "Polish";
		} elseif($nice_lang == "TR") {
			$nice_lang = "Turkish";
		} elseif($nice_lang == "RU") {
			$nice_lang = "Russian";
		} elseif($nice_lang == "PT") {
			$nice_lang = "Portuguese";
		} elseif($nice_lang == "PT") {
			$nice_lang = "Portuguese";
		} elseif($nice_lang == "NL") {
			$nice_lang = "Dutch";
		} elseif($nice_lang == "FI") {
			$nice_lang = "Finnish";
		} elseif($nice_lang == "SE") {
			$nice_lang = "Swedish";
		} elseif($nice_lang == "NW") {
			$nice_lang = "Norwegian";
		} elseif($nice_lang == "DK") {
			$nice_lang = "Dansk";
		} else {
			$nice_queueMode = "Other";
		}
		return $nice_lang;
	}
}