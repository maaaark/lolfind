<?php

class Item extends \Eloquent {
    protected $connection = 'mysql2';
    protected $table      = 'items';

    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];



}