<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserCommentRating;

use Illuminate\Support\Facades\Auth;

class UserCommentRatingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function rate(Request $request, $comment_id) {
        $rating = new UserCommentRating;
        $rating->user_id = auth()->user()->id;
        $rating->comment_id = $comment_id;
        $rating->rating = $request->input('rating');
        $rating->save();
        return redirect()->back();
    }

    public function update(Request $request, $comment_id) {
        UserCommentRating::where('user_id', '=', auth()->user()->id)->where('comment_id', '=', $comment_id)
        ->update(['rating' => $request->input('rating')]);
        return redirect()->back();
    }

    public function destroy($comment_id) {
        $rating = UserCommentRating::where('user_id', '=', auth()->user()->id)->where('comment_id', '=', $comment_id);
        $rating->delete();
        return redirect()->back();
    }
}
