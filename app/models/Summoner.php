<?php

class Summoner extends \Eloquent {

    private $summoner_update_interval = 60;
    private $current_season = "SEASON2015";

    private $allowed_regions = array(
        "euw" => array("status" => true, "api_endpoint" => "https://euw.api.pvp.net", "name" => "Europe West", "platform_id" => "EUW1"), // PlatformId -> für Spectator Mode
        "na"  => array("status" => true, "api_endpoint" => "https://euw.api.pvp.net", "name" => "Nordamerika", "platform_id" => "NA1")
    );


    protected $connection = 'mysql2';

    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    //protected $fillable = [];


    public function games()
    {
        return $this->hasMany('Game', 'summoner_id', 'summoner_id');
    }

    public function fav1()
    {
        return $this->hasOne('Champion', 'champion_id', 'fav_champion_1');
    }

    public function fav2()
    {
        return $this->hasOne('Champion', 'champion_id', 'fav_champion_2');
    }

    public function fav3()
    {
        return $this->hasOne('Champion', 'champion_id', 'fav_champion_3');
    }

    public function seasonchampstats()
    {
        return $this->hasMany('Seasonchampstat')
            ->order_by('games', 'desc');
    }

    public function seasonrankedstats()
    {
        return $this->belongsTo('Seasonrankedstat');
    }

    public function user()
    {
        return $this->belongsTo('User', "summoner_id", "summoner_id");
    }

    public function refresh_games()
    {
        $api_key = Config::get('api.key');
        $summoner_data = "https://".$this->region.".api.pvp.net/api/lol/".$this->region."/v1.3/game/by-summoner/".$this->summoner_id."/recent?api_key=".$api_key;
        $json = @file_get_contents($summoner_data);
        if($json === FALSE) {
            return Redirect::to("/")->with("error", "There was an error with the Riot API, please try again later! Code: 005");
        } else {
            $obj = json_decode($json, true);

            foreach($obj["games"] as $game) {

                $recent_game = Game::where('gameId', '=', $game["gameId"])->where('summoner_id', '=', $this->summoner_id)->first();
                if(!isset($recent_game)) {

                    $newGame = new Game;

                    $more_details = "https://".$this->region.".api.pvp.net/api/lol/".$this->region."/v2.2/match/".$game["gameId"]."?api_key=".$api_key;
                    $json2 = @file_get_contents($more_details);
                    if($json2 === FALSE) {

                        $newGame->incomplete = true;
                        $newGame->towerKills = 0;
                        $newGame->firstTower = 0;
                        $newGame->inhibitorKills = 0;
                        $newGame->firstBaron = 0;
                        $newGame->firstBlood = 0;
                        $newGame->firstInhibitor = 0;
                        $newGame->baronKills = 0;
                        $newGame->dragonKills = 0;
                        $newGame->firstDragon = 0;
                        $newGame->doubleKills = 0;
                        $newGame->tripleKills = 0;
                        $newGame->quadraKills = 0;
                        $newGame->pentaKills = 0;
                        $newGame->firstBloodKill = 0;
                        $newGame->exp_pm_zeroToTen = 0;
                        $newGame->exp_pm_tenToTwenty = 0;
                        $newGame->exp_pm_twentyToThirty = 0;
                        $newGame->exp_pm_thirtyToEnd = 0;
                        $newGame->gold_pm_zeroToTen = 0;
                        $newGame->gold_pm_tenToTwenty = 0;
                        $newGame->gold_pm_twentyToThirty = 0;
                        $newGame->gold_pm_thirtyToEnd = 0;
                        $newGame->cs_pm_zeroToTen = 0;
                        $newGame->cs_pm_tenToTwenty = 0;
                        $newGame->cs_pm_twentyToThirty = 0;
                        $newGame->cs_pm_thirtyToEnd = 0;

                    } else {
                        $details = json_decode($json2, true);

                        if(!isset($details["teams"])) {
                            return Redirect::to("/")->with("error", "There was an error with the Riot API, please try again later! Code: 004");
                        }

                        foreach($details["teams"] as $game_details) {
                            if($game["teamId"] == $game_details["teamId"]) {
                                $newGame->towerKills = $game_details["towerKills"];
                                $newGame->firstTower = $game_details["firstTower"];
                                $newGame->inhibitorKills = $game_details["inhibitorKills"];
                                $newGame->firstBaron = $game_details["firstBaron"];
                                $newGame->firstBlood = $game_details["firstBlood"];
                                $newGame->firstInhibitor = $game_details["firstInhibitor"];
                                $newGame->baronKills = $game_details["baronKills"];
                                $newGame->dragonKills = $game_details["dragonKills"];
                                $newGame->firstDragon = $game_details["firstDragon"];
                            }
                        }

                        foreach($details["participants"] as $my_game_details) {
                            if($my_game_details["championId"] == $game["championId"]) {

                                $newGame->doubleKills = $my_game_details["stats"]["doubleKills"];
                                $newGame->tripleKills = $my_game_details["stats"]["tripleKills"];
                                $newGame->quadraKills = $my_game_details["stats"]["quadraKills"];
                                $newGame->pentaKills = $my_game_details["stats"]["pentaKills"];


                                if(isset($my_game_details["stats"]["firstBloodKill"])) {
                                    $newGame->firstBloodKill = $my_game_details["stats"]["firstBloodKill"];
                                } else {
                                    $newGame->firstBloodKill = 0;
                                }
                                if(isset($my_game_details["stats"]["firstBloodAssist"])) {
                                    $newGame->firstBloodAssist = $my_game_details["stats"]["firstBloodAssist"];
                                } else {
                                    $newGame->firstBloodAssist = 0;
                                }


                                $newGame->role = $my_game_details["timeline"]["role"];
                                $newGame->lane = $my_game_details["timeline"]["lane"];


                                if(isset($my_game_details["timeline"]["xpPerMinDeltas"]["zeroToTen"])) {
                                    $newGame->exp_pm_zeroToTen = $my_game_details["timeline"]["xpPerMinDeltas"]["zeroToTen"];
                                } else {
                                    $newGame->exp_pm_zeroToTen = 0;
                                }

                                if(isset($my_game_details["timeline"]["xpPerMinDeltas"]["tenToTwenty"])) {
                                    $newGame->exp_pm_tenToTwenty = $my_game_details["timeline"]["xpPerMinDeltas"]["tenToTwenty"];
                                } else {
                                    $newGame->exp_pm_tenToTwenty = 0;
                                }

                                if(isset($my_game_details["timeline"]["xpPerMinDeltas"]["twentyToThirty"])) {
                                    $newGame->exp_pm_twentyToThirty = $my_game_details["timeline"]["xpPerMinDeltas"]["twentyToThirty"];
                                } else {
                                    $newGame->exp_pm_twentyToThirty = 0;
                                }

                                if(isset($my_game_details["timeline"]["xpPerMinDeltas"]["thirtyToEnd"])) {
                                    $newGame->exp_pm_thirtyToEnd = $my_game_details["timeline"]["xpPerMinDeltas"]["thirtyToEnd"];
                                } else {
                                    $newGame->exp_pm_thirtyToEnd = 0;
                                }



                                if(isset($my_game_details["timeline"]["goldPerMinDeltas"]["zeroToTen"])) {
                                    $newGame->gold_pm_zeroToTen = $my_game_details["timeline"]["goldPerMinDeltas"]["zeroToTen"];
                                } else {
                                    $newGame->gold_pm_zeroToTen = 0;
                                }

                                if(isset($my_game_details["timeline"]["goldPerMinDeltas"]["tenToTwenty"])) {
                                    $newGame->gold_pm_tenToTwenty = $my_game_details["timeline"]["goldPerMinDeltas"]["tenToTwenty"];
                                } else {
                                    $newGame->gold_pm_tenToTwenty = 0;
                                }

                                if(isset($my_game_details["timeline"]["goldPerMinDeltas"]["twentyToThirty"])) {
                                    $newGame->gold_pm_twentyToThirty = $my_game_details["timeline"]["goldPerMinDeltas"]["twentyToThirty"];
                                } else {
                                    $newGame->gold_pm_twentyToThirty = 0;
                                }

                                if(isset($my_game_details["timeline"]["goldPerMinDeltas"]["thirtyToEnd"])) {
                                    $newGame->gold_pm_thirtyToEnd = $my_game_details["timeline"]["goldPerMinDeltas"]["thirtyToEnd"];
                                } else {
                                    $newGame->gold_pm_thirtyToEnd = 0;
                                }



                                if(isset($my_game_details["timeline"]["creepsPerMinDeltas"]["zeroToTen"])) {
                                    $newGame->cs_pm_zeroToTen = $my_game_details["timeline"]["creepsPerMinDeltas"]["zeroToTen"];
                                } else {
                                    $newGame->cs_pm_zeroToTen = 0;
                                }

                                if(isset($my_game_details["timeline"]["creepsPerMinDeltas"]["tenToTwenty"])) {
                                    $newGame->cs_pm_tenToTwenty = $my_game_details["timeline"]["creepsPerMinDeltas"]["tenToTwenty"];
                                } else {
                                    $newGame->cs_pm_tenToTwenty = 0;
                                }

                                if(isset($my_game_details["timeline"]["creepsPerMinDeltas"]["twentyToThirty"])) {
                                    $newGame->cs_pm_twentyToThirty = $my_game_details["timeline"]["creepsPerMinDeltas"]["twentyToThirty"];
                                } else {
                                    $newGame->cs_pm_twentyToThirty = 0;
                                }

                                if(isset($my_game_details["timeline"]["creepsPerMinDeltas"]["thirtyToEnd"])) {
                                    $newGame->cs_pm_thirtyToEnd = $my_game_details["timeline"]["creepsPerMinDeltas"]["thirtyToEnd"];
                                } else {
                                    $newGame->cs_pm_thirtyToEnd = 0;
                                }


                            }
                        }


                    }

                    if(!isset($game["stats"]["item0"])) { $item0 = 0; }	else { $item0 = $game["stats"]["item0"]; }
                    if(!isset($game["stats"]["item1"])) { $item1 = 0; }	else { $item1 = $game["stats"]["item1"]; }
                    if(!isset($game["stats"]["item2"])) { $item2 = 0; }	else { $item2 = $game["stats"]["item2"]; }
                    if(!isset($game["stats"]["item3"])) { $item3 = 0; }	else { $item3 = $game["stats"]["item3"]; }
                    if(!isset($game["stats"]["item4"])) { $item4 = 0; }	else { $item4 = $game["stats"]["item4"]; }
                    if(!isset($game["stats"]["item5"])) { $item5 = 0; }	else { $item5 = $game["stats"]["item5"]; }
                    if(!isset($game["stats"]["item6"])) { $item6 = 0; }	else { $item6 = $game["stats"]["item6"]; }
                    if(!isset($game["stats"]["totalHeal"])) { $totalHeal = 0; }	else { $totalHeal = $game["stats"]["totalHeal"]; }
                    if(!isset($game["stats"]["killingSprees"])) { $killingSprees = 0; }	else { $killingSprees = $game["stats"]["killingSprees"]; }
                    if(!isset($game["stats"]["wardKilled"])) { $wardKilled = 0; }	else { $wardKilled = $game["stats"]["wardKilled"]; }
                    if(!isset($game["stats"]["turretsKilled"])) { $turretsKilled = 0; }	else { $turretsKilled = $game["stats"]["turretsKilled"]; }
                    if(!isset($game["stats"]["minionsKilled"])) { $minionsKilled = 0; }	else { $minionsKilled = $game["stats"]["minionsKilled"]; }
                    if(!isset($game["stats"]["neutralMinionsKilled"])) { $neutralMinionsKilled = 0; }	else { $neutralMinionsKilled = $game["stats"]["neutralMinionsKilled"]; }
                    if(!isset($game["stats"]["neutralMinionsKilledEnemyJungle"])) { $neutralMinionsKilledEnemyJungle = 0; }	else { $neutralMinionsKilledEnemyJungle = $game["stats"]["neutralMinionsKilledEnemyJungle"]; }
                    if(!isset($game["stats"]["wardPlaced"])) { $wardPlaced = 0; } else { $wardPlaced = $game["stats"]["wardPlaced"]; }
                    if(!isset($game["stats"]["assists"])) { $assists = 0; }	else { $assists = $game["stats"]["assists"]; }
                    if(!isset($game["stats"]["numDeaths"])) { $numDeaths = 0; }	else { $numDeaths = $game["stats"]["numDeaths"]; }
                    if(!isset($game["stats"]["championsKilled"])) { $championsKilled = 0; }	else { $championsKilled = $game["stats"]["championsKilled"]; }
                    if(!isset($game["stats"]["totalDamageTaken"])) { $totalDamageTaken = 0; } else { $totalDamageTaken = $game["stats"]["totalDamageTaken"]; }
                    if(!isset($game["stats"]["totalDamageDealt"])) { $totalDamageDealt = 0; } else { $totalDamageDealt = $game["stats"]["totalDamageDealt"]; }


                    $newGame->summoner_id = $this->summoner_id;
                    $newGame->championId = $game["championId"];
                    $newGame->gameId = $game["gameId"];
                    $newGame->assists = $assists;
                    $newGame->numDeaths = $numDeaths;
                    $newGame->championsKilled = $championsKilled;
                    $newGame->goldEarned = $game["stats"]["goldEarned"];
                    $newGame->wardPlaced = $wardPlaced;
                    $newGame->item0 = $item0;
                    $newGame->item1 = $item1;
                    $newGame->item2 = $item2;
                    $newGame->item3 = $item3;
                    $newGame->item4 = $item4;
                    $newGame->item5 = $item5;
                    $newGame->item6 = $item6;
                    $newGame->spell1 = $game["spell1"];
                    $newGame->spell2 = $game["spell2"];
                    $newGame->gameMode = $game["gameMode"];
                    $newGame->wardKilled = $wardKilled;
                    $newGame->totalHeal = $totalHeal;
                    $newGame->totalDamageTaken = $totalDamageTaken;
                    $newGame->totalDamageDealt = $totalDamageDealt;
                    $newGame->killingSprees = $killingSprees;
                    $newGame->timePlayed = $game["stats"]["timePlayed"];
                    $newGame->turretsKilled = $turretsKilled;
                    $newGame->subType = $game["subType"];
                    $newGame->gameType = $game["gameType"];
                    $newGame->minionsKilled = $minionsKilled;
                    $newGame->neutralMinionsKilled = $neutralMinionsKilled;
                    $newGame->neutralMinionsKilledEnemyJungle = $neutralMinionsKilledEnemyJungle;
                    $newGame->mapId = $game["mapId"];
                    $newGame->teamId = $game["teamId"];
                    $newGame->level = $game["stats"]["level"];
                    $mil = $game["createDate"];
                    $newGame->createDate = $mil;
                    $newGame->win = $game["stats"]["win"];
                    $newGame->save();

                    $newGame->items()->attach($newGame->id, array("item_id"=>$item0));
                    $newGame->items()->attach($newGame->id, array("item_id"=>$item1));
                    $newGame->items()->attach($newGame->id, array("item_id"=>$item2));
                    $newGame->items()->attach($newGame->id, array("item_id"=>$item3));
                    $newGame->items()->attach($newGame->id, array("item_id"=>$item4));
                    $newGame->items()->attach($newGame->id, array("item_id"=>$item5));
                    $newGame->items()->attach($newGame->id, array("item_id"=>$item6));

                }
                unset($recent_game);
            }

        }


    }

    public function refresh_summoner($region, $clean_summoner_name, $summoner_id, $update){
        $summoner = Summoner::where("summoner_id","=",$summoner_id)->where("region","=",$region)->first();
        $summonertimecheck = Summoner::where("summoner_id","=",$summoner_id)->where("region","=",$region)->where('updated_at', '<', \Carbon\Carbon::now()->subSeconds(300))->first();
        if($summonertimecheck or $update == 1 or $summoner->solo_division == 'none'){
            $api_key = Config::get('api.key');
            $summoner_data = "https://".$region.".api.pvp.net/api/lol/".$region."/v1.4/summoner/by-name/".$clean_summoner_name."?api_key=".$api_key;
            $json = @file_get_contents($summoner_data);
            if($json === FALSE) {
                //return Redirect::to("/")->with("error", "There was an error with the Riot API, please try again later! Code: 003");
            } else {
                $obj = json_decode($json, true);
                $summoner->summoner_id = $obj[$clean_summoner_name]["id"];
                $summoner->name = $obj[$clean_summoner_name]["name"];
                $summoner->profileIconId = $obj[$clean_summoner_name]["profileIconId"];
                $summoner->summonerLevel = $obj[$clean_summoner_name]["summonerLevel"];
                $summoner->revisionDate = $obj[$clean_summoner_name]["revisionDate"];
                $summoner->region = $region;
                if($summoner->created_at == $summoner->updated_at){
                    $update = 1;
                }
                $summoner_stats = "https://".$region.".api.pvp.net/api/lol/".$region."/v1.3/stats/by-summoner/".$summoner->summoner_id."/summary?season=SEASON2015&api_key=".$api_key;
                $json2 = @file_get_contents($summoner_stats);
                if($json2 === FALSE) {
                    return $json2;
                    //return Redirect::to('/')->withInput()->with('error', "API Fehler");
                } else {
                    $obj2 = json_decode($json2, true);
                    if(isset($obj2["playerStatSummaries"])){
                        foreach($obj2["playerStatSummaries"] as $gamemode){
                            if($gamemode["playerStatSummaryType"] == 'RankedSolo5x5'){
                                $summoner->ranked_wins = $gamemode['wins'];
                                $summoner->ranked_losses = $gamemode['losses'];
                            }
                            if($gamemode["playerStatSummaryType"] == 'Unranked'){
                                $summoner->unranked_wins = $gamemode['wins'];
                            }
                            if($gamemode["playerStatSummaryType"] == 'RankedTeam5x5'){
                                $summoner->teamranked_wins = $gamemode['wins'];
                                $summoner->teamranked_losses = $gamemode['losses'];
                            }
                        }
                    }
                    $summoner->save();
                }

                $stattest = Seasonchampstat::where("summoner_id","=",$summoner_id)->where("season","=", 2015)->first();
                if( $update == 1 or !$stattest ){
                    $summoner_rankedstats = "https://".$region.".api.pvp.net/api/lol/".$region."/v2.5/league/by-summoner/".$summoner->summoner_id."?api_key=".$api_key;
                    $json3 = @file_get_contents($summoner_rankedstats);
                    if($json3 === FALSE) {
                        //return Redirect::to("/")->with("error", "There was an error with the Riot API, please try again later! Code: 002");
                    } else {
                        $obj3 = json_decode($json3, true);
                        foreach($obj3[$summoner->summoner_id] as $ranked){
                            if($ranked['queue']=="RANKED_SOLO_5x5"){
                                $summoner->solo_name = $ranked["name"];
                                $summoner->solo_tier = $ranked["tier"];
                                foreach($ranked['entries'] as $division){
                                    if($division['playerOrTeamId'] == $summoner->summoner_id){
                                        $summoner->solo_division = $division["division"];
                                    }
                                }
                            }
                            if($ranked['queue']=="RANKED_TEAM_3x3"){
                                $summoner->team3_name = $ranked["name"];
                                $summoner->team3_tier = $ranked["tier"];
                                foreach($ranked['entries'] as $division){
                                    if($division['playerOrTeamId'] == $summoner->summoner_id){
                                        $summoner->team3_division = $division["division"];
                                    }
                                }
                            }
                            if($ranked['queue']=="RANKED_TEAM_5x5"){
                                $summoner->team5_name = $ranked["name"];
                                $summoner->team5_tier = $ranked["tier"];
                                foreach($ranked['entries'] as $division){
                                    if($division['playerOrTeamId'] == $summoner->summoner_id){
                                        $summoner->team5_division = $division["division"];
                                    }
                                }
                            }
                        }
                        $summoner->touch();
                        $summoner->save();
                    }
                }
            }
        }
    }

    public function refresh_seasonchampstats($region, $summoner_id, $update){
        $api_key = Config::get('api.key');
        $summoner = Summoner::where("summoner_id","=",$summoner_id)->first();
        $stattest = Seasonrankedstat::where("summoner_id","=",$summoner_id)->where("season","=", 2015)->first();
        $stats = Summoner::where("summoner_id","=",$summoner_id)->where("region","=",$region)->where('updated_at', '<', \Carbon\Carbon::now()->subSeconds(300))->first();
        if($stats or $update == 1 or !$stattest ){
            $summoner_stats = "https://".$region.".api.pvp.net/api/lol/".$region."/v1.3/stats/by-summoner/".$summoner_id."/ranked?season=SEASON2015&api_key=".$api_key;
            $json = @file_get_contents($summoner_stats);
            if($json === FALSE) {
                //return Redirect::to("/")->with("error", "There was an error with the Riot API, please try again later! Code: 001");
            } else {
                $obj = json_decode($json, true);
                foreach($obj['champions'] as $champstats){
                    if($champstats['id'] != 0){
                        $stats = Seasonchampstat::where("summoner_id","=",$summoner_id)->where("champion_id","=", $champstats['id'])->where("season","=", 2015)->first();
                        if(!$stats) {
                            $stats = new Seasonchampstat;
                        }
                        $stats->summoner_id = $summoner_id;
                        $stats->champion_id = $champstats['id'];
                        $stats->wins = $champstats['stats']['totalSessionsWon'];
                        $stats->losses = $champstats['stats']['totalSessionsLost'];
                        $stats->kills = $champstats['stats']['totalChampionKills'];
                        $stats->deaths = $champstats['stats']['totalDeathsPerSession'];
                        $stats->assists = $champstats['stats']['totalAssists'];
                        $stats->creeps = $champstats['stats']['totalMinionKills'];
                        $stats->games = $champstats['stats']['totalSessionsPlayed'];
                        $stats->season = 2015;
                        $stats->touch();
                        $stats->save();

                    }elseif($champstats['id'] == 0){
                        $rankedstats = Seasonrankedstat::where("summoner_id","=",$summoner_id)->where("season","=", 2015)->first();
                        if(!$rankedstats){
                            $rankedstats = new Seasonrankedstat;
                        }
                        $rankedstats->summoner_id = $summoner_id;
                        $rankedstats->wins = $champstats['stats']['totalSessionsWon'];
                        $rankedstats->losses = $champstats['stats']['totalSessionsLost'];
                        $rankedstats->kills = $champstats['stats']['totalChampionKills'];
                        $rankedstats->deaths = $champstats['stats']['totalDeathsPerSession'];
                        $rankedstats->assists = $champstats['stats']['totalAssists'];
                        $rankedstats->creeps = $champstats['stats']['totalMinionKills'];
                        $rankedstats->games = $champstats['stats']['totalSessionsPlayed'];
                        $rankedstats->doublekills = $champstats['stats']['totalDoubleKills'];
                        $rankedstats->tripplekills = $champstats['stats']['totalTripleKills'];
                        $rankedstats->quadrakills = $champstats['stats']['totalQuadraKills'];
                        $rankedstats->pentakills = $champstats['stats']['totalPentaKills'];
                        $rankedstats->maxkills = $champstats['stats']['maxChampionsKilled'];
                        $rankedstats->maxdeaths = $champstats['stats']['maxNumDeaths'];
                        $rankedstats->neutralcreeps = $champstats['stats']['totalNeutralMinionsKilled'];
                        $rankedstats->gold = $champstats['stats']['totalGoldEarned'];
                        $rankedstats->damagetaken = $champstats['stats']['totalDamageTaken'];
                        $rankedstats->damage = $champstats['stats']['totalDamageDealt'];
                        $rankedstats->touch();
                        $rankedstats->season = 2015;
                        $rankedstats->save();
                    }
                    unset($stats);
                }
            }
            $stats = Seasonchampstat::where("summoner_id","=",$summoner_id)->orderBy('games', 'desc')->get();
            $summoner->touch();
            $summoner->save();
            return $stats;
        }
    }


    public function addSummoner($region, $summoner_name){
        $region = trim(strtolower($region));
        if(isset($this->allowed_regions[$region]) && isset($this->allowed_regions[$region]["status"]) && $this->allowed_regions[$region]["status"] == true){
            $data = Summoner::where('name', 'LIKE', trim($summoner_name))->where("region","=",$region)->first();

            $need_api_request = true;
            if(isset($data["id"]) && $data["id"] > 0){
                $date1   = date('Y-m-d H:i:s');
                $date2   = $data["last_update_maindata"];
                $diff    = abs(strtotime($date2) - strtotime($date1));
                $mins    = floor($diff / 60);

                Session::put('summoner_id', $data["summoner_id"]);

                if($mins < $this->summoner_update_interval){
                    $need_api_request = false;
                }
            }

            if($need_api_request){
                $clean_summoner_name = str_replace(" ", "", $summoner_name);
                $clean_summoner_name = strtolower($clean_summoner_name);
                $clean_summoner_name = mb_strtolower($clean_summoner_name, 'UTF-8');

                $summoner_in_db = Summoner::where("name","=",$summoner_name)->first();
                if(!$summoner_in_db) {
                    $api_key 		   = Config::get('api.key');
                    $summoner_name_url = trim(str_replace(" ", "%20", $region));
                    $summoner_data     = $this->allowed_regions[$region]["api_endpoint"]."/api/lol/".$region."/v1.4/summoner/by-name/".$clean_summoner_name."?api_key=".$api_key;
                    $json = @file_get_contents($summoner_data);
                    if($json === FALSE) {
                        return false;
                        //return Redirect::to("/")->with("error", "There was an error with the Riot API, please try again later! Code: 005");
                    } else {
                        $obj = json_decode($json, true);
                        $summoner = Summoner::where("name","=",$obj[$clean_summoner_name]["name"])->where("region","=",$region)->first();
                        if(!$summoner) {
                            $summoner = new Summoner;
                        }
                        $summoner->summoner_id = $obj[$clean_summoner_name]["id"];

                        $summoner->name = $obj[$clean_summoner_name]["name"];
                        $summoner->profileIconId = $obj[$clean_summoner_name]["profileIconId"];
                        $summoner->summonerLevel = $obj[$clean_summoner_name]["summonerLevel"];
                        $summoner->revisionDate = $obj[$clean_summoner_name]["revisionDate"];
                        $summoner->region = $region;
                        $summoner->last_update_maindata = date('Y-m-d H:i:s');

                        $summoner_stats = $this->allowed_regions[$region]["api_endpoint"]."/api/lol/".$region."/v1.3/stats/by-summoner/".$summoner->summoner_id."/summary?season=".$this->current_season."&api_key=".$api_key;
                        $json2 = @file_get_contents($summoner_stats);
                        if($json2 === FALSE) {
                            return false;
                            //return View::make('searches.show_result', compact('searchString', 'news', 'champs', 'players', 'teams', 'summoner'));
                        } else {
                            $obj2 = json_decode($json2, true);
                            if(isset($obj2["playerStatSummaries"])){
                                foreach($obj2["playerStatSummaries"] as $gamemode){
                                    if($gamemode["playerStatSummaryType"] == 'RankedSolo5x5'){
                                        $summoner->ranked_wins   = $gamemode['wins'];
                                        $summoner->ranked_losses = $gamemode['losses'];
                                        $summoner->ranked_data   = json_encode($gamemode);
                                    }
                                    if($gamemode["playerStatSummaryType"] == 'Unranked'){
                                        $summoner->unranked_wins = $gamemode['wins'];
                                        $summoner->unranked_data = json_encode($gamemode);
                                    }
                                    if($gamemode["playerStatSummaryType"] == 'RankedTeam5x5'){
                                        $summoner->teamranked_wins   = $gamemode['wins'];
                                        $summoner->teamranked_losses = $gamemode['losses'];
                                        $summoner->teamranked_data   = json_encode($gamemode);
                                    }
                                }
                            }
                            //$summoner = $this->updateRankedData($summoner, $summoner->summoner_id, $region);
                            $summoner->save();
                            Session::put('summoner_id', $summoner->summoner_id);
                            return true;
                        }
                    }
                } else {
                    //$summoner = Summoner::where("name","=",trim($summoner_name))->first();
                    //$user->summoner_id = $summoner->summoner_id;
                    //$user->save();
                    Session::put('summoner_id', $summoner_in_db->summoner_id);
                    return true;
                }
            }
            return true;
        } else {
            //echo "gesperrte region";
            return false;
        }
    }
    
    public static function update_summoner($summoner_id, $region, $update_ranked_data = true){
        $allowed_regions   = Config::get('api.allowed_regions');
        $api_key 		   = Config::get('api.key');
        $current_season    = Config::get('api.current_season');
        $summoner_data     = $allowed_regions[$region]["api_endpoint"]."/api/lol/".$region."/v1.4/summoner/".$summoner_id."?api_key=".$api_key;
        $json = @file_get_contents($summoner_data);
        if($json === FALSE) {
            return false;
        } else {
            $obj = json_decode($json, true);
            $summoner = Summoner::where("summoner_id","=",$summoner_id)->where("region","=",$region)->first();
            if(!$summoner) {
                $summoner = new Summoner;
            }
            $summoner->summoner_id = $obj[$summoner_id]["id"];
            $summoner->name = $obj[$summoner_id]["name"];
            $summoner->profileIconId = $obj[$summoner_id]["profileIconId"];
            $summoner->summonerLevel = $obj[$summoner_id]["summonerLevel"];
            $summoner->revisionDate = $obj[$summoner_id]["revisionDate"];
            $summoner->region = $region;
            $summoner->last_update_maindata = date('Y-m-d H:i:s');
            $summoner_stats = $allowed_regions[$region]["api_endpoint"]."/api/lol/".$region."/v1.3/stats/by-summoner/".$summoner->summoner_id."/summary?season=".$current_season."&api_key=".$api_key;
            $json2 = @file_get_contents($summoner_stats);
            if($json2 === FALSE) {
                return View::make('searches.show_result', compact('searchString', 'news', 'champs', 'players', 'teams', 'summoner'));
            } else {
                $obj2 = json_decode($json2, true);
                if(isset($obj2["playerStatSummaries"])){
                    foreach($obj2["playerStatSummaries"] as $gamemode){
                        if($gamemode["playerStatSummaryType"] == 'RankedSolo5x5'){
                            $summoner->ranked_wins   = $gamemode['wins'];
                            $summoner->ranked_losses = $gamemode['losses'];
                            $summoner->ranked_data   = json_encode($gamemode);
                        }
                        if($gamemode["playerStatSummaryType"] == 'Unranked'){
                            $summoner->unranked_wins = $gamemode['wins'];
                            $summoner->unranked_data = json_encode($gamemode);
                        }
                        if($gamemode["playerStatSummaryType"] == 'RankedTeam5x5'){
                            $summoner->teamranked_wins   = $gamemode['wins'];
                            $summoner->teamranked_losses = $gamemode['losses'];
                            $summoner->teamranked_data   = json_encode($gamemode);
                        }
                    }
                }

                if($update_ranked_data){
                    $summoner = Summoner::updateRankedData($summoner, $summoner->summoner_id, $region);
                }
                $summoner->save();
            }
            return $summoner;
        }
    }
    
    public static function updateRankedData($summoner, $summonerId, $region){
		$api_key         = Config::get('api.key');
		$allowed_regions = Config::get('api.allowed_regions');
		$content         = @file_get_contents($allowed_regions[$region]["api_endpoint"]."/api/lol/".$region."/v2.5/league/by-summoner/".$summonerId."/entry?api_key=".$api_key);
		if($content === FALSE) {
			return $summoner;
		} else {
			$json = json_decode($content, true);
			if(isset($json[$summonerId])){
				$ranked_data = array();
				foreach($json[$summonerId] as $entry){
					$array = array();
					$array["name"] 			= str_replace("'", "&lsquo;", $entry["name"]);
					$array["tier"] 			= $entry["tier"];
					$array["division"] 		= $entry["entries"][0]["division"];
					$array["league_points"] = $entry["entries"][0]["leaguePoints"];
					$array["wins"] 			= $entry["entries"][0]["wins"];
					$array["losses"] 		= $entry["entries"][0]["losses"];
					$array["isHotStreak"]   = $entry["entries"][0]["isHotStreak"];
					$array["isVeteran"] 	= $entry["entries"][0]["isVeteran"];
					$array["isFreshBlood"]  = $entry["entries"][0]["isFreshBlood"];
					$array["isInactive"]    = $entry["entries"][0]["isInactive"];
					$array["queue"] 		= $entry["queue"];
					$ranked_data[$array["queue"]] = $array;

                    if(trim($array["queue"]) == "RANKED_SOLO_5x5"){
    					$summoner->solo_division = $entry["entries"][0]["division"];
    					$summoner->solo_tier	 = $entry["tier"];
    					$summoner->solo_name	 = str_replace("'", "&lsquo;", $entry["name"]);
                    }
				}
				$json_encode = json_encode($ranked_data);
				$summoner->ranked_summary = $json_encode;
			}
		}
		return $summoner;
	}
}