<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Comment;

class CommentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string|min:20',
            'rating' => 'nullable|integer'
        ];
    }

    public function updateComment(Comment $comment)
    {
        $comment->update($this->all());
        if ($comment->commentable_type === 'App\Article') {
            return redirect()->route('articles.show',  $comment->commentable->slug)->with('message', 'komentarz użytkownika ' . $comment->user->name . ' został edytowany');
        } else {
            return redirect()->route('videos.show', $comment->commentable->id)->with('message', 'komentarz użytkownika ' . $comment->user->name . ' został edytowany');
        }
    }
}
