<?php

class RankedTeamInvitation extends \Eloquent {
    protected $table = 'ranked_team_invitations';
    
    public function team()
    {
        return RankedTeam::where("id", "=", $this->team)->get();
    }
}