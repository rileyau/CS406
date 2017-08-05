<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostRating extends Model
{
    protected $table = 'user_post_ratings';
    protected $primaryKey = array('user_id', 'post_id');
    public $incrementing = false;   
}
