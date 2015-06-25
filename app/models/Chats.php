<?php

class Chats extends \Eloquent {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql2';
    protected $table      = 'chats';
    private   $other_user;
    
    public function sender(){
        return User::where("id", "=", $this->sender)->first();
    }
    
    public function receiver(){
        return User::where("id", "=", $this->receiver)->first();
    }
    
    public function otherUser($user){
        if($this->other_user){
            return $this->other_user;
        }
        
        if($user == $this->sender){
            return User::where("id", "=", $this->receiver)->first();
        }
        return User::where("id", "=", $this->sender)->first();
    }
    
    public static function chatsList($user){
        if(Auth::check()){
            return $chats = Chats::where("sender", "=", $user)->orWhere("receiver", "=", $user)->orderBy("id", "DESC")->groupBy("hash")->get();
        }
        return false;
    }
    
    public function chatsWidth($user){
        
    }
    
    public static function unread_count($user){
        if(Auth::check()){
            $users_arr = Chats::where("receiver", "=", $user)->where("read_status", "=", 0)->groupBy("hash")->get();
            return array(
               "count" => $users_arr->count(),
               "users" => $users_arr,
            );
        }
        return array("count" => 0, "users" => array());
    }
}