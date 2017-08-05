<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Board;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index() {
        $posts = Post::paginate(5);

        $data = array (
            'posts'=> $posts,
        );

        return view('posts.index')->with($data);
    }

    public function create($name)
    {
        $board = Board::find($name);
        $data = array(
            'board' => $board,
            'title' => 'New Post'
        );

        return view('posts.create')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
       
        $board = $request->input('board');
        //Add post to DB
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->board = $board;
        $post->user_id = auth()->user()->id;
        $post->save();

        return redirect('/b/'.$board)->with('success', 'Post created');
    }

    public function show($name, $id)
    {
        $board = Board::find($name);
        $post = Post::find($id);

        $subbed = false;

        if(!Auth::guest()) {
            $subbed = $board->userIsSubbed(Auth::user()->id);
        }

         $data = array(
            'title' => $post->title,
            'post' => $post,
            'board' => $board,
            'subbed' =>$subbed
        );

        return view('posts.show')->with($data);
    }

    public function edit($name, $id)
    {
        $board = Board::find($name);
        $post = Post::find($id);

        $subbed = false;

        if(!Auth::guest()) {
            $subbed = $board->userIsSubbed(Auth::user()->id);
        }

         $data = array(
            'title' => $post->title,
            'post' => $post,
            'board' => $board,
            'subbed' =>$subbed
        );

        //Check for correct user
        if(auth()->user()->id != $post->user_id) {
            return redirect('/b/$board->name/posts/$id')->with('error', 'Unauthorized Page');
        }

        return view('posts.edit')->with($data);
    }

    public function update(Request $request, $name, $id)
    {

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        //Add updated post to DB
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');

        $post->save();

        return redirect('/b/'.$name.'/posts/'.$id)->with('success', 'Post updated');
    }

    public function destroy($name, $id)
    {
        $post = Post::find($id);

        $post->delete();
        return redirect('/b/'.$name)->with('success', 'Post removed');
    }
}
