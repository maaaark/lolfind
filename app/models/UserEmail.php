<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class UserEmail extends Eloquent {

	protected $connection = 'mysql2';
    protected $table = 'users_emails';

}
