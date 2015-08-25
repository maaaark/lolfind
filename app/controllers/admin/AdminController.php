<?php

class AdminController extends BaseController {

    public function index(){
        return View::make("admin.index");
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
