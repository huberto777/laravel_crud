<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AlbumCreateRequest;
use App\Http\Requests\AlbumUpdateRequest;
use App\Album;
use Auth;
use Storage;

class AlbumsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'checkAdmin'])->only('create', 'store', 'update', 'destroy', 'edit');
    }

    public function index()
    {
        $albums = Album::orderBy('id', 'desc')->get();

        return view('albums.index', compact('albums'));
    }

    public function create()
    {
        return view('albums.create');
    }

    public function store(AlbumCreateRequest $request)
    {
        $album = Album::create($request->all() + ['user_id' => Auth::user()->id]);

        return redirect()->route('albums.index')->with('message', 'album ' . $request->input('name') . ' został dodany');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        return view('albums.show', ['album' => $album]);
    }

    public function edit(Album $album)
    {
        return view('albums.create', compact('album'));
    }


    public function update(AlbumUpdateRequest $request, Album $album)
    {
        $album->update($request->all());

        return redirect()->route('albums.show', $album->id)->with('message', 'album ' . $album->name . ' został zmieniony');
    }

    public function destroy(Album $album)
    {
        $album->delete();
        foreach ($album->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }

        return redirect()->route('albums.index')->with('alert', 'album ' . $album->name . ' został usunięty');
    }

}
