<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Subscription;

class SubscriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($name) {
        $user_id = auth()->user()->id;
        $board = $name;

        if($board->userIsSubbed($user_id)) {
            return redirect('/b/'.$name);
        }

        $sub = new Subscription;
        $sub->user_id = $user_id;
        $sub->board = $board;

        $sub->save();

        return redirect('/b/'.$name);
    }

    public function destroy($name) {
        $sub = Subscription::where('user_id', '=', auth()->user()->id)->where('board', '=', $name);

        $sub->delete();
        return redirect('/b/'.$name)->with('success', 'Successfully unsubscribed');
    }
}
