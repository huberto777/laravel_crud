@extends('layouts.app')
@section('title')
	@if($video ?? false)
		edycja video: {{ $video->title }}
	@else
		dodanie video
	@endif
@endsection
@section('content')
	<div class="jumbotron bg-dark text-white">
		@if($video ?? false)
			<h2>Edycja video: {{ $video->title }}</h2>
		@else
			<h2>Dodanie video</h2>
		@endif
	</div>
	@include('error')
	<div class="jumbotron bg-dark text-white">
		@if($video ?? false)
			<form action="{{ route('videos.update',$video->id) }}" method="post">
				{{ method_field('put') }}
		@else
			<form action="{{ route('videos.store') }}" method="post">
		@endif
			<div class="form-group row">
				<label for="title" class="col-form-label col-md-2 text-md-right">tytuł:</label>
				<div class="col-md-8">
					<input type="text" class="form-control" name="title" value="{{ $video->title ?? old('title') }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="url" class="col-form-label col-md-2 text-md-right">url:</label>
				<div class="col-md-8">
					<input type="text" class="form-control" name="url" value="{{ $video->url ?? old('url') }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="description" class="col-form-label col-md-2 text-md-right">opis:</label>
				<div class="col-md-8">
					<textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ $video->description ?? old('description') }}</textarea>
				</div>
			</div>
			<div class="form-group row">
				<label for="tags" class="col-form-label col-md-2 text-md-right">tagi:</label>
				<div class="col-md-8">
					<select multiple class="form-control" name="tags[]" id="">
						@foreach($tags as $tag)
							<option value="{{ $tag->id }}"
								@if($video ?? false)
									@foreach($video->tags as $tagVideo)
										@if($tagVideo->id === $tag->id) selected
										@endif
									@endforeach
								@endif
							>{{ $tag->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-8 offset-md-2">
					@if($video ?? false)
						<button type="submit" class="btn btn-block btn-outline-danger">edytuj</button>
					@else
						<button type="submit" class="btn btn-block btn-outline-success">zapisz</button>
					@endif
				</div>
			</div>
				{{ csrf_field() }}
			</form>
	</div>
@endsection
