<?php

class AdminUsersController extends BaseController {

    public function index(){
        $users_count     = DB::connection("mysql2")->select(DB::raw("SELECT COUNT(*) AS count FROM users"));
        $summoners_count = DB::connection("mysql2")->select(DB::raw("SELECT COUNT(*) AS count FROM summoners"));

        return View::make("admin.users.index", array(
            "users_count" => $users_count[0],
            "summoners_count" => $summoners_count[0],
        ));
    }

    public function search(){
        $searched_region    = "";
        $searched_summoner  = "";
        $summoner_list      = false;
        if(Input::get("summoner_name") && trim(Input::get("summoner_name")) != ""){
            $searched_summoner = trim(Input::get("summoner_name"));
            if(Input::get("region") && trim(Input::get("region")) != ""){
                $searched_region = Input::get("region");
            }

            if($searched_region && trim($searched_region) != "" && trim(strtolower($searched_region)) != "any"){
                $summoner_list = Summoner::where("name", "LIKE", $searched_summoner)->where("region", "=", $searched_region)->where("verify", "=", "1")->get();
            } else {
                $summoner_list = Summoner::where("name", "LIKE", $searched_summoner)->where("verify", "=", "1")->get();
            }
        }

        return View::make("admin.users.search", array(
            "searched_region"   => $searched_region,
            "searched_summoner" => $searched_summoner,
            "summoner_list"     => $summoner_list,
        ));
    }

    public function summoner($region, $summoner_id){
        $summoner = Summoner::where("region", "=", $region)->where("summoner_id", "=", $summoner_id)->first();
        if(isset($summoner->id) && $summoner->id > 0){
            $problems = array();
            $user     = User::where("region", "=", $region)->where("summoner_id", "=", $summoner->summoner_id)->first();
            if(!isset($user->id) || $user->id < 1){
                $user = false;
                $problems[] = array(    // Wenn Summoner auf Verify gesetzt wurde aber Benutzer nicht gespeichert wurde, da die Registrierung abgebrochen wurde
                    "type"      => "register_verifiy_cancel",
                    "title"     => "Verified but not connected",
                    "message"   => "The summoner was verified but the registration process was canceled before finishing.",
                );
            }

            return View::make("admin.users.summoner", array(
                "user"      => $user,
                "summoner"  => $summoner,
                "problems"  => $problems,
            ));
        }
        return Redirect::to("/admin/users")->with("error", "Summoner not found");
    }

    public function summoner_verify_reset($region, $summoner_id){
        $summoner = Summoner::where("region", "=", $region)->where("summoner_id", "=", $summoner_id)->first();
        if(isset($summoner->id) && $summoner->id > 0){
            $problems = array();
            $user     = User::where("region", "=", $region)->where("summoner_id", "=", $summoner->summoner_id)->first();
            if(!isset($user->id) || $user->id < 1){
                $summoner->verify           = 0;
                $summoner->fav_champion_1   = 0;
                $summoner->fav_champion_2   = 0;
                $summoner->fav_champion_3   = 0;
                $summoner->looking_for_team = 0;
                $summoner->search_top       = 0;
                $summoner->search_jungle    = 0;
                $summoner->search_mid       = 0;
                $summoner->search_adc       = 0;
                $summoner->search_support   = 0;
                $summoner->description      = "";
                $summoner->main_lang        = "";
                $summoner->sec_lang         = "";
                $summoner->save();

                return Redirect::to("/admin/users/")->with("success", "Successfully resetted");
            }
        }
        return Redirect::to("/admin/users/summoner/".trim($region)."/".trim($summoner_id))->with("error", "Nothing to reset.");
    }

}
