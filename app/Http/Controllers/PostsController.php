<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\Board;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index() {
        $postsWithRatings = DB::table('posts')
            ->leftJoin(DB::raw("(SELECT sum(rating) as total, post_id FROM user_post_ratings GROUP BY post_id) as ratings"), 'posts.id', 'ratings.post_id')
            ->select('posts.*', DB::raw('COALESCE(ratings.total, 0) AS rating'), DB::raw("COALESCE(if(COALESCE(ratings.total, 0) < 0, -1, 1) * LOG10(abs(COALESCE(ratings.total, 0))), 0) +  (UNIX_TIMESTAMP(created_at) / 45000) as score"))
            ->orderBy('score', 'DESC')
            ->paginate(10);   

        $posts = array();
            
        foreach($postsWithRatings as $item) {
            $obj = new Post((array)$item);
            array_push($posts, $obj);
        }

        $data = array (
            'posts'=> $posts,
            'links' => $postsWithRatings
        );

        return view('posts.index')->with($data);
    }

    public function subbed() {
        $postsWithRatings = DB::table('posts')
            ->whereIn("board", function($query){
                $query->select('board')
                ->from('subscriptions')
                ->where('user_id', auth()->user()->id);
            })
            ->leftJoin(DB::raw("(SELECT sum(rating) as total, post_id FROM user_post_ratings GROUP BY post_id) as ratings"), 'posts.id', 'ratings.post_id')
            ->select('posts.*', DB::raw('COALESCE(ratings.total, 0) AS rating'), DB::raw("COALESCE(if(COALESCE(ratings.total, 0) < 0, -1, 1) * LOG10(abs(COALESCE(ratings.total, 0))), 0) +  (UNIX_TIMESTAMP(created_at) / 45000) as score"))
            ->orderBy('score', 'DESC')
            ->paginate(10);   

        $posts = array();
            
        foreach($postsWithRatings as $item) {
            $obj = new Post((array)$item);
            array_push($posts, $obj);
        }

        $data = array (
            'posts'=> $posts,
            'links' => $postsWithRatings
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
        $comments = $post->comments;

        $subbed = false;

        if(!Auth::guest()) {
            $subbed = $board->userIsSubbed(Auth::user()->id);
        }

         $data = array(
            'title' => $post->title,
            'post' => $post,
            'board' => $board,
            'comments' => $comments,
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
