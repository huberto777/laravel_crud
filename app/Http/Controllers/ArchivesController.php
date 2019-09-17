<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Article, Video};
use Carbon\Carbon;

class ArchivesController extends Controller
{
    public function archiveArticles(Request $request)
    {
        return view('articles.index', [
            'articles' => Article::latest()->whereYear('created_at', $request->year)->get(),
            'year' => $request->year
        ]);
    }

    public function archiveVideos(Request $request)
    {
        return view('videos.index', [
            'videos' => Video::whereYear('created_at', $request->year)->whereMonth('created_at', Carbon::parse($request->month))->paginate(15),
            'year' => $request->year,
            'month' => $request->month
        ]);
    }
}
