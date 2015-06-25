<?php

if(isset($_GET["data"]) && isset($_GET["sID"]) && $_GET["sID"] > 0){
	$sID     = $_GET["sID"];
	$out     = array();

	// Matchhistory
	require_once 'matchhistory.class.php';
	$matchhistory 		   = new MatchhistoryView($this->allowed_regions, $region, $this->summoner_update_interval);
	$matchhistory_data 	   = $matchhistory->show($sID);
	$out["matchhistory"]   = $matchhistory_data["template"];
	
	// Ranked-Stats
	require_once 'ranked_stats.class.php';
	$ranked_stats 	       = new RankedStatsView($this->allowed_regions, $region, $this->summoner_update_interval);
	$ranked_stats_data     = $ranked_stats->show($sID);
	$out["ranked_stats"] = $ranked_stats_data["template"];

	// Daten ausgeben
	echo json_encode($out);
}
