@extends('layouts.app')
@section('title','edycja komentarza')
@section('content')
	<div class="jumbotron bg-dark text-white">
		<h3>Edycja komentarza o ID: {{ $comment->id }}</h3>
	</div>
	@include('error')
	@include('session')
	<div class="jumbotron text-white bg-dark">
        <form {{ $novalidate }} action="{{ route('editComment',$comment->id) }}" method="post">
            {{ method_field('put') }}
			<div class="form-group row">
				<label for="content" class="col-md-2 col-form-label text-md-right">treść:</label>
				<div class="col-md-10">
					<textarea name="content" id="" cols="30" rows="10" class="form-control">{{ $comment->content }}</textarea>
				</div>
            </div>
            @if($comment->commentable_type == 'App\Article')
			<div class="form-group row">
				<label for="rating" class="col-md-2 col-form-label text-md-right">ocena:</label>
				<div class="col-md-10">
					<select name="rating" id="rating" class="form-control">
                        @for($i=1; $i<=5; $i++)
							<option value="{{ $i }}" @if($i == $comment->rating) selected @endif>
								{{ $i }}
							</option>
						@endfor

					</select>
				</div>
            </div>
            @endif
			<div class="form-group row">
				<div class="col-md-10 offset-md-2">
					<button type="submit" class="btn btn-block btn-danger">edytuj</button>
					@if($comment->commentable_type == 'App\Article')
						<a href="{{ route('articles.show',$comment->commentable->slug) }}" class="btn btn-outline-warning btn-block">powrót</a>
					@else
						<a href="{{ route('videos.show',$comment->commentable->id) }}" class="btn btn-outline-warning btn-block">powrót</a>
					@endif
				</div>
			</div>
			{{ csrf_field() }}
		</form>
	</div>
@endsection


