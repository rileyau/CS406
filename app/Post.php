<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserPostRating;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $table = 'posts';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['id', 'title', 'body', 'created_at', 'updated_at', 'user_id', 'board'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
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

    public function getTopComments() {
        $result = DB::table('comments')
            ->where('post_id', '=', $this->id)
            ->leftJoin(DB::raw("(SELECT sum(rating) as total, comment_id FROM user_comment_ratings GROUP BY comment_id) as ratings"), 'comments.id', 'ratings.comment_id')
            ->select('comments.*', DB::raw('COALESCE(ratings.total, 0) AS rating'))
            ->orderBy('rating', 'DESC')
            ->paginate(5);   

        return ($result);
    }
    

}
