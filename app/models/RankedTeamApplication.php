<?php

class RankedTeamApplication extends \Eloquent {
    protected $table = 'ranked_team_applications';
    
    public function team()
    {
        return RankedTeam::where("id", "=", $this->team)->get();
    }
}