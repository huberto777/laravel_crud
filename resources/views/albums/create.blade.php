@extends('layouts.app')
@section('title')
	@if($album ?? false)
		edycja albumu: {{ $album->name }}
	@else
		dodanie albumu
	@endif
@endsection
@section('content')
	<div class="jumbotron bg-dark text-white">
		@if($album ?? false)
			<h2>Edycja albumu: {{ $album->name }}</h2>
		@else
			<h2>Dodanie albumu</h2>
		@endif
	</div>
	@include('error')
	<div class="jumbotron text-white bg-dark">
		@if($album ?? false)
			<form {{ $novalidate }} action="{{ route('albums.update',$album->id) }}" method="post">
				{{ method_field('put') }}
		@else
			<form {{ $novalidate }} action="{{ route('albums.store') }}" method="post">
		@endif
			<div class="form-group row">
				<label for="name" class="col-form-label text-md-right col-md-2">nazwa:</label>
				<div class="col-md-8">
					<input type="text" name="name" class="form-control" value="{{ $album->name ?? old('name') }}">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-8 offset-md-2">
					<button type="submit"
						@if($album ?? false)
							class="btn btn-block btn-outline-danger"
						@else
							class="btn btn-block btn-outline-success"
						@endif
					>
						@if($album ?? false)
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
