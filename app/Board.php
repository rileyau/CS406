<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Subscription;
use App\Post;

class Board extends Model
{
    public $primaryKey = 'name';
    public $incrementing = false;

    public function userIsSubbed($id) {
        return ( count(Subscription::where('user_id', '=', $id)->where('board', '=', $this->name)->get()) > 0);
    }

    public function getTopPosts() {
        $result = DB::table('posts')
            ->where('board', '=', $this->name)
            ->leftJoin(DB::raw("(SELECT sum(rating) as total, post_id FROM user_post_ratings GROUP BY post_id) as ratings"), 'posts.id', 'ratings.post_id')
            ->select('posts.*', DB::raw('COALESCE(ratings.total, 0) AS rating'))
            ->orderBy('rating', 'DESC')
            ->paginate(5);   

        return ($result);
    }

    public function getHotPosts() {
        $result = DB::table('posts')
            ->where('board', '=', $this->name)
            ->leftJoin(DB::raw("(SELECT sum(rating) as total, post_id FROM user_post_ratings GROUP BY post_id) as ratings"), 'posts.id', 'ratings.post_id')
            ->select('posts.*', DB::raw('COALESCE(ratings.total, 0) AS rating'), DB::raw("COALESCE(if(COALESCE(ratings.total, 0) < 0, -1, 1) * LOG10(abs(COALESCE(ratings.total, 0))), 0) +  (UNIX_TIMESTAMP(created_at) / 45000) as score"))
            ->orderBy('score', 'DESC')
            ->paginate(5);   

        return ($result);
    }

    public function getNewPosts() {
        $result = Post::where('board', '=', $this->name)->orderBy('created_at', 'DESC')->paginate(5);
        return $result;
    }
}
