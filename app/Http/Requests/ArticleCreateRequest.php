<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\{Article};
use Str;
use Storage;

class ArticleCreateRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:50|unique:articles',
            'description' => 'required|string|min:20',
            'path' => 'image|max:500',
            'category_id' => 'required|integer|exists:categories,id',
            'tags' => 'required|exists:tags,id'
        ];
    }

    public function createArticle()
    {
        $dir = date('Y.m');

        $article = Article::create([
            'title' => $this->input('title'),
            'slug' => Str::slug($this->input('title')),
            'description' => $this->input('description'),
            'path' => $this->hasFile('path') ? Storage::disk('public')->put('articles_' . $dir, $this->file('path')) : null,
            'user_id' => $this->user()->id,
            'category_id' => $this->input('category_id'),
            'created_at' => new \DateTime()
        ]);

        $article->tags()->attach($this->input('tags'));
        return redirect()->route('articles.index')->with('message', 'artykuł "' . $this->title . '" został dodany');
    }
}
