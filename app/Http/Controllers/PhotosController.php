<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PhotoCreateRequest;
use Storage;
use App\Photo;

class PhotosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkAdmin');
    }

    public function store(PhotoCreateRequest $request)
    {
        return $request->uploadPhoto();
    }

    public function destroy(Photo $photo)
    {
        $photo->delete();
        Storage::disk('public')->delete($photo->path);

        return redirect()->back()->with('alert', 'zdjęcie zostało usunięte z albumu: ' . $photo->album->name);
    }
}
