<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $board, $post) {
        $this->validate($request, [
            'body' => 'required'
        ]);
    
        //Add comment to DB
        $comment = new Comment;
        $comment->body = $request->input('body');
        $comment->post_id = $post;
        $comment->user_id = auth()->user()->id;
        $comment->parent_id = null;
        $comment->save();

        return redirect('/b/'.$board.'/posts/'.$post)->with('success', 'Comment created');
    }
}