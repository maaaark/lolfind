<?php

class Notification extends \Eloquent {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql2';
    protected $table = 'notifications';
    
    public function user(){
        return User::where("id", "=", $this->user)->first();
    }

    public static function notificationsList($user){
        if(Auth::check()){
            return Notification::where("user", "=", $user)->orderBy("id", "DESC")->take(20)->get();
        }
        return false;
    }
}
