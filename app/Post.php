<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserPostRating;

class Post extends Model
{
    protected $table = 'posts';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function userHasRated($user) {
        $userRating = UserPostRating::where('user_id', '=', $user)->where('post_id', '=', $this->id)->first();

        if($userRating == null) {
            return 0;
        }
        else {
            return $userRating->rating;
        }
    }

    public function totalRating() {
        return UserPostRating::where('post_id', '=', $this->id)->sum('rating');
    }
}
