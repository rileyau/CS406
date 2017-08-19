<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['id', 'body', 'created_at', 'updated_at', 'user_id', 'parent_id'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function totalRating() {
        return UserCommentRating::where('comment_id', '=', $this->id)->sum('rating');
    }

    public function userHasRated($user) {
        $userRating = UserCommentRating::where('user_id', '=', $user)->where('comment_id', '=', $this->id)->first();

        if($userRating == null) {
            return 0;
        }
        else {
            return $userRating->rating;
        }
    }
}
