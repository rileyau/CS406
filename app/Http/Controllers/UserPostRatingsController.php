<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\UserPostRating;

class UserPostRatingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function rate(Request $request, $post) {
        $rating = new UserPostRating;
        $rating->user_id = auth()->user()->id;
        $rating->post_id = $post;
        $rating->rating = $request->input('rating');
        $rating->save();
        return redirect()->back();
    }

    public function update(Request $request, $post) {
        UserPostRating::where('user_id', '=', auth()->user()->id)->where('post_id', '=', $post)
        ->update(['rating' => $request->input('rating')]);
        return redirect()->back();
    }

    public function destroy($post) {
        $rating = UserPostRating::where('user_id', '=', auth()->user()->id)->where('post_id', '=', $post);
        $rating->delete();
        return redirect()->back();
    }
}
