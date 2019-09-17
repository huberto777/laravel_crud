@extends('layouts.app')
@section('title', $album->name)
@section('content')
	@include('session')
	@include('error')
	<div class="jumbotron bg-dark text-white">
		<h2>Album: {{ $album->name }}</h2>
		<h5>ilość zdjęć: <div class="badge badge-pill badge-warning">{{ $album->photos->count() }}</h5>
		@if(Auth::user() && Auth::user()->hasRole(['admin']))
			<hr class="border-warning">
			<h4>Dodanie zdjęć do albumu: {{ $album->name }}</h4>
			<hr class="border-warning">
			<form action="{{ route('photos.store') }}" method="post" enctype="multipart/form-data">
				<div class="form-group row">
					<label for="albumPictures" class="col-form-label col-md-2 text-md-right">dodaj zdjęcia:</label>
					<div class="col-md-8">
						<input type="file" name="albumPictures[]" id="albumPictures" class="form-control-file" multiple>
					</div>
				</div>
				<input type="hidden" name="album_id" value="{{ $album->id }}">
				<div class="form-group row">
					<div class="col-md-8 offset-md-2">
						<button type="submit" class="btn btn-block btn-outline-success">zapisz</button>
					</div>
				</div>
				{{ csrf_field() }}
			</form>
		@endif
	</div>
	@if(count($album->photos) == null)
		<div class="alert alert-danger">do tego albumu nie dodano jeszcze zdjęć</div>
	@else
		<div class="jumbotron bg-dark text-white">
			@foreach($album->photos->chunk(4) as $chunked_photos)
				<div class="row">
					@foreach($chunked_photos as $photo)
						<div class="col-md-3">
							<div class="card-img mb-2 pb-2 bg-dark"><img src="{{ asset("storage/{$photo->path}") }}" class="img-thumbnail bg-dark">
								@if(Auth::user() && Auth::user()->hasRole(['admin']))
									<form action="{{ route('photos.destroy',$photo->id) }}" method="post">
										{{ method_field('delete') }}
										<button type="submit" class="btn btn-sm btn-block btn-danger">usuń</button>
										{{ csrf_field() }}
									</form>
								@endif
							</div>
						</div>
					@endforeach
				</div>
			@endforeach
		</div>
	@endif
@endsection
