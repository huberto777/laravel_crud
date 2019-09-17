<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Article, Tag, Video};

class TagsController extends Controller
{
    public function articleTag(Article $article, Tag $tag)
    {
        return view('articles.index', [
            'tag' => $tag,
            'articles' => $tag->articles
        ]);
    }

    public function videoTag(Video $video, Tag $tag)
    {
        return view('videos.index', [
            'tag' => $tag,
            'videos' => $tag->videos
        ]);
    }
}
