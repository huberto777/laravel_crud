@extends('layouts.app')
@section('title')
	@if($article ?? false)
		edycja artykułu
	@else
		dodanie artykułu
	@endif
@endsection
@section('content')
	<div class="jumbotron bg-dark text-white">
		@if($article ?? false)
			<h2>Edycja artykułu: {{ $article->title }}</h2>
		@else
			<h2>Dodanie artykułu</h2>
		@endif
	</div>
	@include('error')
	<div class="jumbotron bg-dark text-white">
		@if($article ?? false)
			<form {{ $novalidate }} action="{{ route('articles.update',$article->slug) }}" enctype='multipart/form-data' method="post">
			{{ method_field('put') }}
		@else
			<form {{ $novalidate }} action="{{ route('articles.store') }}" enctype='multipart/form-data' method="post">
		@endif
			<div class="form-group row">
				<label for="title" class="col-form-label text-md-right col-md-2">tytuł:</label>
				<div class="col-md-8">
					<input type="text" name="title" class="form-control" value="{{ $article->title ?? old('title')  }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="description" class="col-form-label text-md-right col-md-2">treść:</label>
				<div class="col-md-8">
					<textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $article->description ?? old('description') }}</textarea>
				</div>
			</div>
			<div class="form-group row">
				<label for="path" class="col-form-label text-md-right col-md-2">dodaj obrazek:</label>
				<div class="col-md-8">
    				<input type="file" name="path" class="form-control-file" id="path">
    			</div>
			</div>
			@if($article ?? null)
	            <div class="form-group row">
    				<div class="offset-lg-2 col-md-3 col-sm-6">
                        <img class="img-responsive" src="{{ asset("storage/$article->path") }}" width="140" height="100" alt="...">
                    </div>
                </div>
        	@endif
			<div class="form-group row">
				<label for="category_id" class="col-form-label text-md-right col-md-2">kategoria:</label>
				<div class="col-md-8">
					<select class="form-control" id="category_id" name="category_id">
						<option value=""></option>
					    @foreach($categories as $category)
					    	<option value="{{ $category->id }}" @if( ($article ?? false) && $category->id === $article->category->id) selected @endif>{{ $category->name }}</option>
					    @endforeach
    				</select>
    			</div>
			</div>
			<div class="form-group row">
				<label for="tags[]" class="col-form-label text-md-right col-md-2">tagi:</label>
				<div class="col-md-8">
					<select multiple class="form-control" id="tags[]" name="tags[]">
					    @foreach($tags as $tag)
					    	<option value="{{ $tag->id }}" @if( ($article ?? false) && $article->tags->contains($tag->id) ) selected @endif>{{ $tag->name }}</option>
					    @endforeach
    				</select>
    			</div>
			</div>
			<div class="form-group row">
				<div class="col-md-8 offset-md-2">
					<button type="submit"
						@if($article ?? false)
							class="btn btn-block btn-danger"
						@else
							class="btn btn-block btn-success"
						@endif>
						@if($article ?? false)
							edytuj
						@else
							dodaj artykuł
						@endif
					</button>
				</div>
			</div>
			{{ csrf_field() }}
		</form>
	</div>
@endsection
