<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view('pages.index')->with('title', 'Home');
    }

    public function about(){
        return view('pages.about')->with('title', 'About');
    }

    public function services(){
        
        $data = array(
            'title' => 'Services',
            'services' => ['Web Design', 'Programming', 'SEO']
        );

        return view('pages.services')->with($data);
    }

    public function bootstrap() {
        $data = array (
            'title' => 'Bootstrap'
        );

        return view('pages.test')->with($data);
    }
}
