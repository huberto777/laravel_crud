<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Requests\CommentCreateRequest;
use App\Comment;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkAdmin')->except('store');
    }

    public function store(CommentCreateRequest $request, $commentable_id, $commentable_type)
    {
        return $request->createComment($commentable_id, $commentable_type);
    }

    public function edit(Comment $comment)
    {
        return view('comments.edit', ['comment' => $comment]);
    }

    public function update(CommentUpdateRequest $request, Comment $comment)
    {
        return $request->updateComment($comment);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->back()->with('alert', 'komentarz do artykułu został usunięty');
    }
}
