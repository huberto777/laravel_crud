<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Photo;

class PhotoCreateRequest extends FormRequest
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
            'albumPictures' => 'required',
            'albumPictures.*' => 'image|max:500', //image=>'mimes:jpeg,bmp,png'
            'album_id' => 'required|integer|exists:albums,id'
        ];
    }

    public function uploadPhoto()
    {
        $dir = date('Y.m');

        foreach ($this->file('albumPictures') as $picture) {
            $path = \Storage::disk('public')->put('photos_' . $dir, $picture);

            // $photo = new Photo();
            // $photo->path = $path;
            // $photo->album_id = $this->input('album_id');
            // $photo->save();

            Photo::create([
                'path' => $path,
                'album_id' => $this->input('album_id')
            ]);
        }

        return redirect()->back()->with('message', 'zdjęcia zostały dodane');
    }
}
