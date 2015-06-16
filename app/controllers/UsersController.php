<?php

class UsersController extends \BaseController {
    /**
     * Display the specified resource.
     * GET /teams/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($region, $name)
    {
        $summoner = Summoner::where("region", "=", $region)->where("name", "=", $name)->first();
        $user = $summoner->user;
        return View::make('users.show', compact('user'));
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
            return View::make("users.settings", compact('user'));
        } else {
            return Redirect::to('/login')->with("error", "Bitte einloggen.");
        }
    }

    public function save_settings() {
        if(Auth::check()) {
            $user = Auth::user();
            return View::make("users.settings", compact('user'));
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
                        return Redirect::to('/register/step3')->with("success", "Summoner wurde verifiziert!");
                    }
                }
            }
            return Redirect::to('/register/step2')->with("error", "Keine Runenseite mit dem Namen gefunden.");
        } else {
            return Redirect::to('/register/step1')->with("error", "Session abgelaufen.");
        }

        return Redirect::to('/register/step1')->with("error", "Session abgelaufen.");
    }

    public function step1() {
        return View::make("users.register.step1");
    }

    public function step3() {
        $summoner = Summoner::where("summoner_id", "=", Session::get('summoner_id'))->first();
        return View::make("users.register.step3", compact('summoner'));
    }

    public function step2() {
        if(Session::get('summoner_id')) {
            $summoner = Summoner::where("summoner_id", "=", Session::get('summoner_id'))->first();
            Session::put('region', $summoner->region);
            Session::put('summoner_name', $summoner->name);

            return View::make("users.register.step2", compact('summoner'));
        } else {
            return Redirect::to("/register/step1")->with("error", "Session abgelaufen oder nicht vorhanden!");
        }

    }

    public function step1_save() {
        $input = Input::all();
        $validation = Validator::make($input, User::$step1);

        if ($validation->passes())
        {
            $check_summoner = Summoner::where("name","=", Input::get('summoner_name'))->where("verify","=", 1)->first();
            if(!$check_summoner) {
                $summoner = new Summoner();
                $summoner_found = $summoner->addSummoner(Input::get('region'), Input::get('summoner_name'));
                if($summoner_found) {
                    Session::put('verify_code', str_random(10));
                    return Redirect::to('/register/step2')->with("success", "Summoner bitte verifizieren");
                } else {
                    $messages = $validation->messages();
                    return Redirect::to("/register/step1")
                        ->withInput()
                        ->withErrors($validation)
                        ->with('error', 'Der Beschw&ouml;rer wurde nicht gefunden.')->with('input', Input::all())->with('messages', $messages);
                }
            } else {
                return Redirect::to('/register/step1')->with("error", "Dieser Summoner gehört bereits zu einem Account");
            }

        } else {
            $messages = $validation->messages();
            return Redirect::to("/register/step1")
                ->withInput()
                ->withErrors($validation)
                ->with('error', 'Der Beschw&ouml;rer wurde nicht gefunden.')->with('input', Input::all())->with('messages', $messages);
        }
    }


    public function step3_save() {
        $input = Input::all();
        $validation = Validator::make($input, User::$step3);

        if ($validation->passes())
        {
            $user = User::create($input);
            $user->password = Hash::make(Input::get('password'));
            $user->verify_string = str_random(10);
            $user->summoner_id = Session::get('summoner_id');
            $user->save();
            return Redirect::to('/login')->with("success", "User erstellt - Bitte einloggen");

        } else {
            $messages = $validation->messages();
            return Redirect::to("/register/step3")
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
            return Redirect::to('/account/edit/')->with("success", "Eingaben gespeichert!");
        } else {
            $messages = $validation->messages();
            return Redirect::to("/account/edit/")
                ->withInput()
                ->withErrors($validation)
                ->with('error', 'Es sind Fehler aufgetreten!.')->with('input', Input::all());
        }
    }


    public function login()
    {
        if(Auth::check()) {
            return Redirect::to('/users');
        } else {
            return View::make("layouts.login")->with("error", "Fehler beim einloggen. Username/Passwort falsch.");
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to("/")->with("success", "Du wurdest ausgeloggt");
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
                return Redirect::to("/");

            } else {
                // validation not successful, send back to form
                return Redirect::to('/login');

            }

        }
    }

}