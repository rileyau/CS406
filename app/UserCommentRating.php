<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCommentRating extends Model
{
    protected $table = 'user_comment_ratings';
    protected $primaryKey = array('user_id', 'comment_id');
    public $incrementing = false;  
}
