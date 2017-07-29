<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $primaryKey = array('user_id', 'board');
    public $incrementing = false;   
    public $timestamps = false;
}
