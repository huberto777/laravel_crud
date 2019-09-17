<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Comment;

class CommentCreateRequest extends FormRequest
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

    public function createComment($commentable_id, $commentable_type)
    {
        $type = 'App\\' . $commentable_type;
        $commentable = $type::findOrFail($commentable_id);
        $comment = new Comment();
        $comment->content = $this->input('content');
        $comment->rating = $type == 'App\Article' ? $this->input('rating') : 0;
        $comment->user_id = $this->user()->id;

        $commentable->comments()->save($comment);
        // comments() - metoda zdefiniowana zarówno w modelu Video jak i Article

        return redirect()->back()->with('message', 'komentarz do artykuł został dodany ' . $commentable->title);
    }
}
