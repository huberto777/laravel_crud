<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function like(Request $request, $likeable_id, $likeable_type)
    {
        $type = 'App\\' . $likeable_type;
        $likeable = $type::findOrFail($likeable_id);
        $likeable->users()->attach($request->user()->id);

        return redirect()->back();
    }

    public function unlike(Request $request, $likeable_id, $likeable_type)
    {
        $type = 'App\\' . $likeable_type;
        $likeable = $type::findOrFail($likeable_id);
        $likeable->users()->detach($request->user()->id);

        return redirect()->back();
    }
}
