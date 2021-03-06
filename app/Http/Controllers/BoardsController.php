<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Board;
use App\Post;
use App\User;
use Validator;


class BoardsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function show($name, $filter = 'hot') {
        $board = Board::find($name);
        if($filter != 'top' && $filter != 'hot' && $filter != 'rising' && $filter != 'new') {
            abort(404);
        }
        if($filter == 'new') {
            $posts = $board->getNewPosts();

            $subbed = false;

            if(!Auth::guest()) {
                $subbed = $board->userIsSubbed(Auth::user()->id);
            }

            $data = array (
                'title' => $name,
                'board'=> $board,
                'posts'=> $posts,
                'links' => $posts,
                'subbed' => $subbed
            );
        }

        if($filter == 'top' || $filter == 'hot' || $filter == 'rising') {
            if($filter == 'top') {
                $postsWithRatings = $board->getTopPosts();
            }
            else if($filter == 'hot') {
                $postsWithRatings = $board->getHotPosts();
            }
            else if($filter == 'rising') {
                $postsWithRatings = $board->getRisingPosts();
            }

            $posts = array();
            
            foreach($postsWithRatings as $item) {
                $obj = new Post((array)$item);
                array_push($posts, $obj);
            }

            $subbed = false;

            if(!Auth::guest()) {
                $subbed = $board->userIsSubbed(Auth::user()->id);
            }

            $data = array (
                'title' => $name,
                'board'=> $board,
                'posts'=> $posts,
                'links' => $postsWithRatings,
                'subbed' => $subbed
            );
        }

        return view('boards.index')->with($data);
    }

    public function search(Request $request, $name) {
        $board = Board::find($name);
        $searchQuery = $request->input('searchQuery');

        $posts = $board->getPostsContaining($searchQuery);

        $subbed = false;

        if(!Auth::guest()) {
            $subbed = $board->userIsSubbed(Auth::user()->id);
        }

        $data = array (
            'title' => $name,
            'board'=> $board,
            'posts'=> $posts,
            'links' => $posts,
            'subbed' => $subbed
        );

        return view('boards.index')->with($data);
    }

    public function create() {
        return view('boards.create')->with('title', "Create Board");
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'nullable',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:boards,name|max:50',
            'description' => 'nullable',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // Handle File Upload
        if($request->hasFile('cover_image')){
            //Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            //Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            //Filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;

            //Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);
        }
        else {
            $filenameToStore = NULL;
        }

        //Add post to DB
        $name = $request->input('name');
        $board = new Board;
        $board->name = $name;
        $board->description = $request->input('description');
        $board->created_by = auth()->user()->id;
        $board->banner_image = $filenameToStore;
        $board->save();

        return redirect('/b/'.$name)->with('success', 'Board created');
    }

    public function edit($name) {
        $board = Board::find($name);

        $data = array (
            'title' => 'Edit Board',
            'board'=> $board,
        );

        return view('boards.edit')->with($data);
    }

    public function update(Request $request, $name)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'nullable',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // Handle File Upload
        if($request->hasFile('cover_image')){
            //Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            //Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            //Filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;

            //Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);
        }

        //Update Board in DB
        $board = Board::find($name);
        $board->description = $request->input('description');
        $board->created_by = auth()->user()->id;
        if($request->hasFile('cover_image')){
            $board->banner_image = $filenameToStore;
        }
        $board->save();

        return redirect('/b/'.$name)->with('success', 'Board updated');
    }
}
