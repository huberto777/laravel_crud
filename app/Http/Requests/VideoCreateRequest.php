<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Video;

class VideoCreateRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:50',
            'url' => 'required|url',
            'description' => 'required|string|min:20',
            'tags' => 'required'
        ];
    }

    public function createVideo()
    {
        $video = Video::create($this->all() + [
            'user_id' => \Auth::user()->id,
            'created_at' => new \DateTime()
        ]);
        $video->tags()->attach($this->input('tags'));

        return redirect()->route('videos.index')->with('message', 'video ' . $this->input('title') . ' zostało dodane');
    }
}
