<?php

class RankedTeam extends \Eloquent {
    protected $table = 'ranked_team';
    
    public function player()
    {
        //return $this->hasMany('RankedTeamPlayer', 'team_id', "team_internal_id");
    }
}