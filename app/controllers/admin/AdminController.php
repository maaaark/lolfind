<?php

class AdminController extends BaseController {

    public function index(){
        $info = array(
            "players_looking_for_team" => Summoner::where("looking_for_team", "=", "1")->get()->count(),
            "teams_looking_for_player" => RankedTeam::where("looking_for_players", "=", "1")->get()->count(),
            "applications_send_today"  => RankedTeamApplication::where("created_at", "LIKE", "%".date("Y-m-d")."%")->get()->count(),
            "invitations_send_today"  => RankedTeamInvitation::where("created_at", "LIKE", "%".date("Y-m-d")."%")->get()->count(),
        );

        $roles_info = array(
            "player_looking_for_top" => Summoner::where("looking_for_team", "=", "1")->where("search_top", "=", "1")->get()->count(),
            "player_looking_for_jungle" => Summoner::where("looking_for_team", "=", "1")->where("search_jungle", "=", "1")->get()->count(),
            "player_looking_for_mid" => Summoner::where("looking_for_team", "=", "1")->where("search_mid", "=", "1")->get()->count(),
            "player_looking_for_adc" => Summoner::where("looking_for_team", "=", "1")->where("search_adc", "=", "1")->get()->count(),
            "player_looking_for_support" => Summoner::where("looking_for_team", "=", "1")->where("search_support", "=", "1")->get()->count(),
            
            "teams_looking_for_top" => RankedTeam::where("looking_for_players", "=", "1")->where("looking_for_top", "=", "1")->get()->count(),
            "teams_looking_for_jungle" => RankedTeam::where("looking_for_players", "=", "1")->where("looking_for_jungle", "=", "1")->get()->count(),
            "teams_looking_for_mid" => RankedTeam::where("looking_for_players", "=", "1")->where("looking_for_mid", "=", "1")->get()->count(),
            "teams_looking_for_adc" => RankedTeam::where("looking_for_players", "=", "1")->where("looking_for_adc", "=", "1")->get()->count(),
            "teams_looking_for_support" => RankedTeam::where("looking_for_players", "=", "1")->where("looking_for_support", "=", "1")->get()->count(),
        );

        return View::make("admin.index", array(
            "info"          => $info,
            "roles_info"    => $roles_info,
        ));
    }

    public function network_server(){
    	$array = array();
        $array["test"] = "teamranked.com";

        try {
            $server_response = FIServer::send_width_answer(json_encode(array("type" => "get_server_info", "message" => $array)));
        } catch(Exception $e){
            $server_response = false;
        }

        $server_info = false;
        if(isset($server_response) && $server_response && trim($server_response) != ""){
        	$server_response = trim($server_response);
        	while(substr($server_response, 0, 1) != "{" && strlen($server_response) > 1){
        		$server_response = substr($server_response, 1);
    		}
        	$server_info = json_decode($server_response, true);
        }
        return View::make("admin.network_server", array(
        	"server_info" => $server_info,
    	));
    }

}
