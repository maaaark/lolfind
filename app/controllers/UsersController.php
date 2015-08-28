<?php

class UsersController extends \BaseController {
    private $summoner_update_interval = 60;
    private $allowed_regions;
    private $current_season;

    public function __construct(){
        $this->current_season  = Config::get('api.current_season');
        $this->allowed_regions = Config::get('api.allowed_regions');
    }

    /**
     * Display the specified resource.
     * GET /teams/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($region, $name){
        if(Auth::check()){
            $summoner = Summoner::where("region", "=", $region)->where("name", "=", $name)->first();
            $user = @$summoner->user;
            
            if($user && $user->summoner_id && $user->summoner_id > 0){
                $this->update_summoner($summoner->region, $summoner->name);
                $summoner = Summoner::where("region", "=", $region)->where("id", "=", $summoner->id)->first();

                $user_object = false;
                $user_check  = User::where("summoner_id", "=", $user->summoner_id)->first();
                if(isset($user_check["id"]) && $user_check["id"] > 0){
                    $user_object = $user_check;
                }

                $ranked_teams      = array();
                $ranked_teams_data = RankedTeamPlayer::where("summoner_id", "=", $user->summoner_id)->get();
                foreach($ranked_teams_data as $team_join){
                    $ranked_teams[] = RankedTeam::where("id", "=", $team_join->team)->first();
                }
                return View::make('users.show', compact('user', "user_object", "ranked_teams"));
            } else {
                return View::make('users.show_not_registered', compact('user', "user_object"));
            }
        }
        return View::make("users.show_login");
    }

    public function index() {
        $users = User::orderBy("id", "ASC")->get();
        return View::make("users.index", compact("users"));
    }

    public function edit() {
        if(Auth::check()) {
            $user = Auth::user();
            return View::make("users.edit", compact("user"));
        } else {
            return Redirect::to("/login");
        }
    }


    public function create() {
        //return View::make("users.create");
        return Redirect::to("/register/step1");
    }

    public function settings() {
        if(Auth::check()) {
            $user = Auth::user();
            $summoner = $user->summoner;
            $champions = Champion::orderBy("name", "ASC")->get();
            return View::make("users.settings", compact('user', 'champions', 'summoner'));
        } else {
            return Redirect::to('/login')->with("error", "Bitte einloggen.");
        }
    }

    public function save_settings() {
        if(Auth::check()) {
            $summoner = Auth::user()->summoner;

            $input = Input::all();

            $summoner->fav_champion_1 = $input["fav_champion_1"];
            $summoner->fav_champion_2 = $input["fav_champion_2"];
            $summoner->fav_champion_3 = $input["fav_champion_3"];
            $summoner->description = $input["description"];

            $summoner->main_lang = $input["main_lang"];
            $summoner->sec_lang = $input["sec_lang"];

            if(isset($input["search_top"])) {
                $summoner->search_top = $input["search_top"];
            } else {
                $summoner->search_top = 0;
            }

            if(isset($input["search_jungle"])) {
                $summoner->search_jungle = $input["search_jungle"];
            } else {
                $summoner->search_jungle = 0;
            }

            if(isset($input["search_mid"])) {
                $summoner->search_mid = $input["search_mid"];
            } else {
                $summoner->search_mid = 0;
            }

            if(isset($input["search_adc"])) {
                $summoner->search_adc = $input["search_adc"];
            } else {
                $summoner->search_adc = 0;
            }

            if(isset($input["search_support"])) {
                $summoner->search_support = $input["search_support"];
            } else {
                $summoner->search_support = 0;
            }


            if(isset($input["looking_for_team"])) {
                $summoner->looking_for_team = $input["looking_for_team"];
            } else {
                $summoner->looking_for_team = 0;
            }
            $summoner->save();

            $email_player_invitation = 0;
            if(isset($input["email_player_invitation"]) && $input["email_player_invitation"] == 1){
                $email_player_invitation = 1;
            }
            $email_temp = UserEmail::where("user", "=", Auth::user()->id)->where("network_page", "=", "teamranked")->where("type", "=", "player_invitation")->first();
            if(isset($email_temp->id) && $email_temp->id > 0){
                $email_temp->value = $email_player_invitation;
                $email_temp->save();
            } else {
                $email_temp = new UserEmail;
                $email_temp->network_page = "teamranked";
                $email_temp->user         = Auth::user()->id;
                $email_temp->type         = "player_invitation";
                $email_temp->value        = $email_player_invitation;
                $email_temp->save();
            }

            $email_team_application = 0;
            if(isset($input["email_team_application"]) && $input["email_team_application"] == 1){
                $email_team_application = 1;
            }
            $email_temp = UserEmail::where("user", "=", Auth::user()->id)->where("network_page", "=", "teamranked")->where("type", "=", "team_application")->first();
            if(isset($email_temp->id) && $email_temp->id > 0){
                $email_temp->value = $email_team_application;
                $email_temp->save();
            } else {
                $email_temp = new UserEmail;
                $email_temp->network_page = "teamranked";
                $email_temp->user         = Auth::user()->id;
                $email_temp->type         = "team_application";
                $email_temp->value        = $email_team_application;
                $email_temp->save();
            }

            return Redirect::to('/settings');
        } else {
            return Redirect::to('/login')->with("error", "Bitte einloggen.");
        }
    }

    public function verify_summoner() {
        if(Session::get('summoner_id')) {
            $api_key = Config::get('api.key');
            $summoner_data = "https://".Session::get('region').".api.pvp.net/api/lol/".Session::get('region')."/v1.4/summoner/".Session::get('summoner_id')."/runes?api_key=".$api_key;
            $json = @file_get_contents($summoner_data);
            if($json === FALSE) {
                Session::flash('message', 'Kein Summoner gefunden');
                return Redirect::to('/register/step2');
            } else {
                $obj = json_decode($json, true);
                $runes = $obj[Session::get('summoner_id')]["pages"];

                foreach($runes as $page) {
                    if($page["name"] == Session::get('verify_code')) {
                        $summoner = Summoner::where("summoner_id","=", Session::get('summoner_id'))->first();
                        $summoner->verify = 1;
                        $summoner->save();
                        return Redirect::to('/register/step3')->with("success", "Summoner verified!");
                    }
                }
            }
            return Redirect::to('/register/step2')->with("error", "The runepage was not found. Try again 15 seconds after you saved the runepage.");
        } else {
            return Redirect::to('/register/step1')->with("error", "Session timed out.");
        }

        return Redirect::to('/register/step1')->with("error", "Session timed out.");
    }

    public function step1() {
        Session::put('region', "");
        Session::put('summoner_name', "");
        return View::make("users.register.step1");
    }

    public function step3() {
        $summoner = Summoner::where("summoner_id", "=", Session::get('summoner_id'))->first();
        $champions = Champion::orderBy("name","asc")->get();
        return View::make("users.register.step3", compact('summoner', 'champions'));
    }

    public function step4() {
        $summoner = Summoner::where("summoner_id", "=", Session::get('summoner_id'))->first();
        return View::make("users.register.step4", compact('summoner'));
    }

    public function step2() {
        if(Session::get('summoner_id')) {
            $summoner = Summoner::where("summoner_id", "=", Session::get('summoner_id'))->first();

            return View::make("users.register.step2", compact('summoner'));
        } else {
            return Redirect::to("/register/step1")->with("error", "Session timed out");
        }

    }

    public function step1_save() {
        $input = Input::all();
        $validation = Validator::make($input, User::$step1);

        if ($validation->passes())
        {
            $check_summoner = Summoner::where("name","=", Input::get('summoner_name'))->where("region", "=", Input::get('region'))->where("verify","=", 1)->first();
            if(!$check_summoner) {
                $summoner = new Summoner();
                $summoner_found = $summoner->addSummoner(Input::get('region'), Input::get('summoner_name'));
                $summoner = Summoner::where("summoner_id", "=", Session::get('summoner_id'))->where("region", "=", Input::get('region'))->first();
                if($summoner_found && $summoner && isset($summoner->id) && $summoner->id > 0) {
                    Session::put('region', $summoner->region);
                    Session::put('summoner_name', $summoner->name);

                    Session::put('verify_code', str_random(10));
                    return Redirect::to('/register/step2')->with("success", "Please verify your summoner.");
                } else {
                    $messages = $validation->messages();
                    return Redirect::to("/register/step1")
                        ->withInput()
                        ->withErrors($validation)
                        ->with('error', 'The summoner was not found.')->with('input', Input::all())->with('messages', $messages);
                }
            } else {
                return Redirect::to('/register/step1')->with("error", "This summoner is already connected to a flashignite-account.");
            }

        } else {
            $messages = $validation->messages();
            return Redirect::to("/register/step1")
                ->withInput()
                ->withErrors($validation)
                ->with('error', 'The summoner was not found.')->with('input', Input::all())->with('messages', $messages);
        }
    }


    public function step3_save() {
        $input = Input::all();

        $verifier = App::make('validation.presence');
        $verifier->setConnection('mysql2');

        // validate the info, create rules for the inputs
        $rules = User::$rules = array(
            //'email'=>'required|unique:users',
            //'password' => 'confirmed|min:5'
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make($input, $rules);

        $validator->setPresenceVerifier($verifier);



        if ($validator->passes())
        {
            /*
            $user = User::create($input);
            $user->password = Hash::make(Input::get('password'));
            $user->verify_string = str_random(10);
            $user->summoner_id = Session::get('summoner_id');
            $user->save();
            */

            $summoner = Summoner::where("summoner_id", "=", Session::get('summoner_id'))->first();

            $summoner->fav_champion_1 = Input::get('fav_champion_1');
            $summoner->fav_champion_2 = Input::get('fav_champion_2');
            $summoner->fav_champion_3 = Input::get('fav_champion_3');

            $summoner->looking_for_team = Input::get('looking_for_team');

            $summoner->search_top = Input::get('search_top');
            $summoner->search_jungle = Input::get('search_jungle');
            $summoner->search_mid = Input::get('search_mid');
            $summoner->search_adc = Input::get('search_adc');
            $summoner->search_support = Input::get('search_support');
            $summoner->description = Input::get('description');

            $summoner->main_lang = Input::get('main_lang');
            $summoner->sec_lang = Input::get('sec_lang');

            $summoner->save();

            return Redirect::to('/register/step4');

        } else {
            $messages = $validator->messages();
            return Redirect::to("/register/step3")
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'There were validation errors.')->with('input', Input::all())->with('messages', $messages);
        }
    }

    public function step4_save() {
        $input = Input::all();

        $verifier = App::make('validation.presence');
        $verifier->setConnection('mysql2');

        // validate the info, create rules for the inputs
        $rules = User::$rules = array(
            'email'=>'required|unique:users',
            'password' => 'confirmed|min:5'
        );

        $validation = Validator::make($input, $rules);

        if ($validation->passes())
        {
            $user = User::create($input);
            $user->region = Session::get('region');
            $user->password = Hash::make(Input::get('password'));
            $user->verify_string = str_random(10);
            $user->summoner_id = Session::get('summoner_id');
            $user->save();
            return Redirect::to('/login')->with("success", "Your account has been created.");

        } else {
            $messages = $validation->messages();
            return Redirect::to("/register/step4")
                ->withInput()
                ->withErrors($validation)
                ->with('error', 'There were validation errors.')->with('input', Input::all())->with('messages', $messages);
        }
    }

    public function save() {
        $input = Input::all();
        $validation = Validator::make($input, User::$rules);



        if ($validation->passes())
        {
            $user = User::create($input);
            $summoner_found = $user->addSummoner(Input::get('region'), Input::get('summoner_name'), $user);
            if($summoner_found) {
                $user->password = Hash::make(Input::get('password'));
                $user->verify_string = str_random(10);
                $user->save();
                return Redirect::to('/login')->with("success", "User erstellt - Bitte einloggen");
            } else {
                $messages = $validation->messages();
                return Redirect::to("/register")
                    ->withInput()
                    ->withErrors($validation)
                    ->with('error', 'There were validation errors.')->with('input', Input::all())->with('messages', $messages);
            }
        } else {
            $messages = $validation->messages();
            return Redirect::to("/register")
                ->withInput()
                ->withErrors($validation)
                ->with('error', 'There were validation errors.')->with('input', Input::all())->with('messages', $messages);
        }

    }

    public function updateAccount() {
        $input = Input::all();
        $validation = Validator::make($input, User::$rules);
        if ($validation->passes())
        {
            $user = Auth::user();
            $user->update($input);
            if(Input::get('password') != "") {
                $user->password = Hash::make(Input::get('password'));
            }
            $user->save();
            return Redirect::to('/account/edit/')->with("success", "Input saved!");
        } else {
            $messages = $validation->messages();
            return Redirect::to("/account/edit/")
                ->withInput()
                ->withErrors($validation)
                ->with('error', 'An error has occurred!')->with('input', Input::all());
        }
    }


    public function login()
    {
        if(Auth::check()) {
            return Redirect::to('/');
        } else {
            return View::make("layouts.login");
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to("/")->with("success", "You have been logged out");
    }

    public function doLogin()
    {
        // validate the info, create rules for the inputs
        $rules = array();

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('/login')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {

            // create our user data for the authentication
            $userdata = array(
                'email' 	=> Input::get('email'),
                'password' 	=> Input::get('password')
            );

            // attempt to do the login
            if (Auth::attempt($userdata)) {

                // validation successful!
                // redirect them to the secure section or whatever
                // return Redirect::to('secure');
                // for now we'll just echo success (even though echoing in a controller is bad)
                return Redirect::to("/")->with("success", "You have been logged in.");

            } else {
                // validation not successful, send back to form
                return Redirect::to('/login')->withErrors(array('wrongpw' => 'Wrong E-mail address or Password'));;

            }

        }
    }

    public function getNotification(){
        $return = "";
        if(Auth::check()){
            if(Input::get("notification_id") && Input::get("notification_id") > 0){
                $notification = Notification::where("id", "=", Input::get("notification_id"))->first();
                if($notification->user() && $notification->user()->id == Auth::user()->id){
                    echo View::make("users.notification_element", array("notification" => $notification))->render();
                }
            }
        }
    }

    public function ajax_summoner_update($region, $summoner_name){
        $api_key = Config::get('api.key');
        include 'players/ajax.init.php';
    }

    public function applications(){
        if(Auth::check()){
            $applications = RankedTeamApplication::where("user", "=", Auth::user()->id)->get();
            return View::make("users.applications", array(
                "applications" => $applications
            ));
        } else {
            return Redirect::to('/login'); 
        }
    }

    public function update_summoner($region, $summoner_name){
        $region = trim(strtolower($region));
        if(isset($this->allowed_regions[$region]) && isset($this->allowed_regions[$region]["status"]) && $this->allowed_regions[$region]["status"] == true){
            $data = Summoner::where('name', 'LIKE', trim($summoner_name))->where("region","=",$region)->first();
            
            $need_api_request = true;
            if(isset($data["id"]) && $data["id"] > 0){
                $date1   = date('Y-m-d H:i:s');
                $date2   = $data["last_update_maindata"];
                $diff    = abs(strtotime($date2) - strtotime($date1));
                $mins    = floor($diff / 60);

                if($mins < $this->summoner_update_interval){
                    $need_api_request = false;
                }
            }
            
            if($need_api_request){
                $clean_summoner_name = str_replace(" ", "", $summoner_name);
                $clean_summoner_name = strtolower($clean_summoner_name);
                $clean_summoner_name = mb_strtolower($clean_summoner_name, 'UTF-8');

                $api_key           = Config::get('api.key');
                $summoner_name_url = trim(str_replace(" ", "%20", $region));
                $summoner_data     = $this->allowed_regions[$region]["api_endpoint"]."/api/lol/".$region."/v1.4/summoner/by-name/".$clean_summoner_name."?api_key=".$api_key;
                $json = @file_get_contents($summoner_data);
                if($json === FALSE) {
                    return Redirect::to("/")->with("error", "Der Summoner wurde nicht gefunden.");
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
                    $summoner->save();

                    $summoner_stats = $this->allowed_regions[$region]["api_endpoint"]."/api/lol/".$region."/v1.3/stats/by-summoner/".$summoner->summoner_id."/summary?season=".$this->current_season."&api_key=".$api_key;
                    $json2 = @file_get_contents($summoner_stats);
                    if($json2 === FALSE) {
                        return false;
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
                        $summoner = $this->updateRankedData($summoner, $summoner->summoner_id, $region);
                        $summoner->save();
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function updateRankedData($summoner, $summonerId, $region){
        $api_key = Config::get('api.key');
        $content = @file_get_contents($this->allowed_regions[$region]["api_endpoint"]."/api/lol/".$region."/v2.5/league/by-summoner/".$summonerId."/entry?api_key=".$api_key);
        if($content === FALSE) {
            return $summoner;
        } else {
            $json = json_decode($content, true);
            if(isset($json[$summonerId])){
                $ranked_data = array();
                foreach($json[$summonerId] as $entry){
                    $array = array();
                    $array["name"]          = str_replace("'", "&lsquo;", $entry["name"]);
                    $array["tier"]          = $entry["tier"];
                    $array["division"]      = $entry["entries"][0]["division"];
                    $array["league_points"] = $entry["entries"][0]["leaguePoints"];
                    $array["wins"]          = $entry["entries"][0]["wins"];
                    $array["losses"]        = $entry["entries"][0]["losses"];
                    $array["isHotStreak"]   = $entry["entries"][0]["isHotStreak"];
                    $array["isVeteran"]     = $entry["entries"][0]["isVeteran"];
                    $array["isFreshBlood"]  = $entry["entries"][0]["isFreshBlood"];
                    $array["isInactive"]    = $entry["entries"][0]["isInactive"];
                    $array["queue"]         = $entry["queue"];
                    $ranked_data[$array["queue"]] = $array;

                    if(trim($array["queue"]) == "RANKED_SOLO_5x5"){
                        $summoner->solo_division = $entry["entries"][0]["division"];
                        $summoner->solo_tier     = $entry["tier"];
                        $summoner->solo_name     = str_replace("'", "&lsquo;", $entry["name"]);
                    }
                }
                $json_encode = json_encode($ranked_data);
                $summoner->ranked_summary = $json_encode;
            }
        }
        return $summoner;
    }

}