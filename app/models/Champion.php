<?php

class Champion extends \Eloquent {

    protected $guarded = array('id', 'champion_id');
    protected $connection = 'mysql2';

    public function skins()
    {
        return $this->hasMany('Skin');
    }

    public function seasonchampstats()
    {
        return $this->hasMany('seasonchampstat');
    }

    public function skills()
    {
        return $this->hasMany('Skill');
    }

    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];



}