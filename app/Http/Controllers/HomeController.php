<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Article, Video};

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $articles = Article::orderBy('id', 'desc')->limit(3)->get();
        $videos = Video::orderBy('id', 'desc')->limit(1)->get();

        return view('home', compact('articles', 'videos'));
    }
}
