@extends('layouts.app')
@section('title','home')
@section('content')
	<div class="row">
        <div class="col-md-12" align="center">
            <p><h2><b>NAJNOWSZY FILM</b></h2></p>
            <div class="jumbotron text-white bg-dark mb-3">
                @foreach($videos as $video)
                    <h4>{{ $video->title }}</h4>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="{{ $video->url }}?showinfo=0" frameborder="0" allowfullscreen></iframe>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" align="center">
        <a href="{{ route('articles.index') }}" class="btn btn-primary btn-block mb-4">zobacz wszystkie artykuły</a>
            <p><h2><b>NAJNOWSZE ARTYKUŁY</b></h2></p>
        </div>
        @foreach($articles as $article)
            <div class="col-md-4" style="display: flex;">
                <div class="jumbotron text-white bg-dark">
                    <h4>{{ $article->title }}</h4>
                    <div class="card-img mb-2 pb-2 bg-dark"><img src="{{ $article->path != null ? asset("storage/{$article->path}") : $placeholder }}" title="{{ $article->title }}" class="img-fluid img-thumbnail bg-dark">
                    <span class="text-white ml-2">{{ Str::limit($article->description,450) }}</span></div>
                    <hr class="border-warning">
                    <a href="{{ route('articles.show',['id'=>$article->id]) }}">cały artykuł...</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
