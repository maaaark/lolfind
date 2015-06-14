<?php

class RankedTeamPlayer extends \Eloquent {
    protected $table = 'ranked_team_player';
    
    public function summoner()
    {
        return $this->belongsTo('Summoner', "summoner_id", "summoner_id");
    }
}