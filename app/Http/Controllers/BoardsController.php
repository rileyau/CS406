<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Board;
use App\Post;

class BoardsController extends Controller
{
    
    public function show($name) {
        $board = Board::find($name);
        $posts = Post::where('board', $name)->paginate(5);

        $data = array (
            'title' => $name,
            'board'=> $board,
            'posts'=> $posts
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
}
