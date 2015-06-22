<?php
class Helpers {
    public static function diffForHumans($timestamp) {
		$created_timestamp = $timestamp->getTimestamp();
		$current_timestamp = time();
		
		$timediff = $current_timestamp - $created_timestamp;
		
		$minutes = 60;			// 60
		$hours = 3600;		// 60 * 60
		$days = 86400;		// $minutes * 60
		$oneWeek = 604800; 	// $days * 7
		$twoWeek = 1209600; 	// $oneWeek + $oneWeek
		$normalDate = 1814400;
		
		if($timediff < $minutes) {
			$html = "vor " . $timediff . " sekunden";
		} else if ($timediff >= $minutes && $timediff < $hours) {
			//var_dump($timediff,round($timediff / $minutes));
			$outputTime = round($timediff / $minutes);
			$html = "vor " . $outputTime . " minuten";
		} else if ($timediff >= $hours && $timediff < $days) {
			$outputTime = round($timediff / $hours);
			$html = "vor " . $outputTime . " Stunden";
		} else if ($timediff >= $days && $timediff < $twoWeek) {
			$outputTime = round($timediff / $days);
			$html = "vor " . $outputTime . " Tagen";
		} else {
			$html = date("d.m.Y", $created_timestamp);
		}
        return $html;
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
}