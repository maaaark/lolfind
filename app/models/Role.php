<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Role extends Eloquent {

	protected $connection = 'mysql2';
	
    public function user() {
        return $this->hasMany('User');
    }

}
