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

    private function statistics_date_render($date){
        $date       = date("d.m.Y", strtotime($date));
        $heute      = date("d.m.Y");
        $gestern    = date("d.m.Y", time() - 60*60*24);
        $vorgestern = date("d.m.Y", time() - 60*60*24*2);
        if($date == $heute){
            return "Heute";
        }
        elseif($date == $gestern){
            return "Gestern";
        }
        elseif($date == $vorgestern){
            return "Vorgestern";
        }
        return $date;
    }

    public function statistics(){
        $date = date("Y-m-d H:i:s", time() - 60*60*24*7); // Datum von vor 7 Tagen

        // Invitations-Data
        $invitations       = array();
        $invitations_query = DB::select(DB::raw("SELECT COUNT(*) AS count, DATE(created_at) AS date FROM ranked_team_invitations WHERE created_at > :var GROUP BY DATE(ranked_team_invitations.created_at)"), array(
            "var" => $date
        ));
        foreach($invitations_query as $element){
            if(isset($element->count) && isset($element->date)){
                $invitations[] = array(
                    "count" => $element->count,
                    "date" => $this->statistics_date_render($element->date),
                );
            }
        }

        // Applications-Data
        $applications       = array();
        $applications_query = DB::select(DB::raw("SELECT COUNT(*) AS count, DATE(created_at) AS date FROM ranked_team_applications WHERE created_at > :var GROUP BY DATE(ranked_team_applications.created_at)"), array(
            "var" => $date
        ));
        foreach($applications_query as $element){
            if(isset($element->count) && isset($element->date)){
                $applications[] = array(
                    "count" => $element->count,
                    "date" => $this->statistics_date_render($element->date),
                );
            }
        }

        // Chat-Data
        $chats       = array();
        $chats_query = DB::connection('mysql2')->select(DB::raw("SELECT COUNT(*) AS count, DATE(created_at) AS date FROM chats WHERE created_at > :var GROUP BY DATE(chats.created_at)"), array(
            "var" => $date
        ));
        foreach($chats_query as $element){
            if(isset($element->count) && isset($element->date)){
                $chats[] = array(
                    "count" => $element->count,
                    "date" => $this->statistics_date_render($element->date),
                );
            }
        }

        // Notification-Data
        $notifications       = array();
        $notifications_query = DB::connection('mysql2')->select(DB::raw("SELECT COUNT(*) AS count, DATE(created_at) AS date FROM notifications WHERE created_at > :var GROUP BY DATE(notifications.created_at)"), array(
            "var" => $date
        ));
        foreach($notifications_query as $element){
            if(isset($element->count) && isset($element->date)){
                $notifications[] = array(
                    "count" => $element->count,
                    "date" => $this->statistics_date_render($element->date),
                );
            }
        }
        return View::make("admin.statistics", array(
            "invitations"   => $invitations,
            "applications"  => $applications,
            "chats"         => $chats,
            "notifications" => $notifications,
        ));
    }

}
