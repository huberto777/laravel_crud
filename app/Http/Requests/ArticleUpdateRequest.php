<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Article;
use Storage;
use Str;

class ArticleUpdateRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:50|unique:articles,id',
            'description' => 'required|string|min:20',
            'path' => 'image|max:500',
            'category_id' => 'required|integer|exists:categories,id',
            'tags' => 'required|exists:tags,id'
        ];
    }

    public function updateArticle(Article $article)
    {
        $dir = date('Y.m');

        if ($this->hasFile('path'))
            Storage::disk('public')->delete($article->path);

        $article->update([
            'title' => $this->input('title'),
            'slug' => Str::slug($this->input('title')),
            'description' => $this->input('description'),
            'path' => $this->hasFile('path') ? Storage::disk('public')->put('articles_' . $dir, $this->file('path')) : $article->path,
            'category_id' => $this->input('category_id'),
        ]);

        $article->tags()->sync($this->input('tags'));
        $this->session()->flash('message', 'artykuł: ' . $article->title . ' został edytowany');

        return redirect()->route('articles.show', compact('article'));
    }
}
