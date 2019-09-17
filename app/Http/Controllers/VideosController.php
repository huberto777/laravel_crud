<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\VideoCreateRequest;
use App\Http\Requests\VideoUpdateRequest;
use App\{Video, Tag};

class VideosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'checkAdmin'])->only('create', 'edit', 'store', 'update', 'destroy');
    }

    public function index()
    {
        $videos = Video::orderBy('id', 'desc')->get();
        return view('videos.index', compact('videos'));
    }

    public function show(Video $video)
    {
        return view('videos.show', [
            'video' => $video,
            'archives' => Video::selectRaw('year(created_at) year,monthname(created_at) month, count(*) published')
                ->groupBy('year', 'month')
                ->orderBy('created_at', 'desc')
                ->get()
        ]);
    }

    public function create()
    {
        return view('videos.create', ['tags' => Tag::with(['articles', 'videos'])->get()]);
    }

    public function edit(Video $video)
    {
        return view('videos.create', [
            'video' => $video,
            'tags' => Tag::with(['articles', 'videos'])->get()
        ]);
    }

    public function store(VideoCreateRequest $request)
    {
        return $request->createVideo();
    }

    public function update(VideoUpdateRequest $request, Video $video)
    {
        $video->update($request->all());
        $video->tags()->sync($request->input('tags'));

        return redirect()->route('videos.show', compact('video'))->with('message', 'video ' . $video->title . ' zostało zmienione');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        $video->comments()->delete();
        $video->tags()->detach();
        $video->users()->detach();

        return redirect()->back()->with('alert', 'video zostało ' . $video->title . ' usunięte');
    }
}
