<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Article, Category, Tag};
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleUpdateRequest;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'checkAdmin'])->only('create', 'store', 'update', 'destroy', 'edit');
    }

    public function index()
    {
        $articles = Article::orderBy('id', 'desc')->get();

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create', [
            'categories' => Category::with(['articles'])->get(),
            'tags' => Tag::with(['articles', 'videos'])->get()
        ]);
    }

    public function store(ArticleCreateRequest $request)
    {
        return $request->createArticle();
    }

    public function show(Article $article)
    {
        return view('articles.show', [
            'article' => $article,
            'archives' => Article::selectRaw('year(created_at) as year, count(*) published')
                ->groupBy('year')
                ->orderBy('created_at', 'desc')
                ->get()
        ]);
    }

    public function edit(Article $article)
    {
        return view('articles.create', [
            'article' => $article,
            'categories' => Category::with(['articles'])->get(),
            'tags' => Tag::with(['articles', 'videos'])->get()
        ]);
    }

    public function update(ArticleUpdateRequest $request, Article $article)
    {
        return $request->updateArticle($article);
    }

    public function destroy(Article $article)
    {
        $article->comments()->delete();
        $article->delete();
        $article->users()->detach(); // likes
        \Storage::disk('public')->delete($article->path);
        $article->tags()->detach();

        return redirect()->back()->with('alert', 'artykuł: ' . $article->title . ' - został usunięty');
    }
}
