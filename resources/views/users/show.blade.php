@extends('layouts.app')
@section('title',$user->name)
@section('content')
	<div class="jumbotron bg-dark text-white">
		<h3>{{ $user->name }}</h3>
        <hr class="border-warning">
        <div class="card bg-dark">
        	<div class="row">
	        	<div class="col-md-6"><img src="{{ $user->path == null ? $placeholder : asset("storage/{$user->path}")  }}" width="400" height="300" alt="" class="mr-4 img-fluid" className="fluid">
	        	</div>
	        	<div class="col-md-6">
		        	<h5>
		        		<p>adres email: {{ $user->email }}</p>
						<p>rola: {{ $user->roles()->first()->name ?? 'brak roli' }}</p>
						<p>polubienia artykułów: <span class="badge badge-pill badge-warning">{{ $user->larticles()->count() }}</span></p>
						<p>polubienia video: <span class="badge badge-pill badge-warning">{{ $user->lvideos()->count() }}</span></p>
						@if(Auth::user()->hasRole(['admin']))
							<p>dodane artykuły: <span class="badge badge-pill badge-warning">{{ $user->articles()->count() ?? null }}</span></p>
							<p>dodane video: <span class="badge badge-pill badge-warning">{{ $user->videos()->count() ?? null }}</span></p>
							<p>dodane albumy: <span class="badge badge-pill badge-warning">{{ $user->albums()->count() ?? null }}</span></p>
						@endif
						<p>komentarze do artykułów: <span class="badge badge-pill badge-warning">{{ $user->comments()->where('commentable_type','App\Article')->count() ?? null }}</span></p>
						<p>komentarze do video: <span class="badge badge-pill badge-warning">{{ $user->comments()->where('commentable_type','App\Video')->count() ?? null }}</span></p>
		        	</h5>
	        	</div>
	        </div>
        </div>
        @if(Auth::user() && Auth::user()->hasRole(['admin']))
        	<a href="{{ route('users.index') }}" class="btn btn-block btn-warning">powrót do listy użytkowników</a>
        	<a href="{{ route('users.edit',$user->id) }}" class="btn btn-block btn-primary mb-2">edycja użytkownika: {{ $user->name }}</a>
        	<form action="{{ route('users.destroy',$user->id) }}" method="post" onclick="return confirm('na pewno chcesz usunąć użytkownika: {{ $user->name }}')">
        		{{ csrf_field() }}
        		{{ method_field('delete') }}
        		<button type="submit" class="btn btn-block btn-danger">usuń użytkownika {{ $user->name }}</button>
        	</form>
        @endif
	</div>
@endsection
