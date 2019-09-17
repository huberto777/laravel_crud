@extends('layouts.app')
@section('title','edycja: '.$user->name)
@section('content')
	<div class="jumbotron bg-dark text-white">
		<h3>Edycja użytkownika: {{ $user->name }}</h3>
	</div>
	@include('error')
	@include('session')
	<div class="jumbotron bg-dark text-white">
		<form action="{{ route('users.update',$user->id) }}" method="post" enctype='multipart/form-data'>
			{{ method_field('put') }}
			{{ csrf_field() }}
			<div class="form-group row">
				<label for="name" class="col-form-label text-md-right col-md-2">imię:</label>
				<div class="col-md-8">
					<input name="name" type="text" class="form-control" value="{{ $user->name }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="name" class="col-form-label text-md-right col-md-2">email:</label>
				<div class="col-md-8">
					<input name="email" type="text" class="form-control" value="{{ $user->email }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="path" class="col-form-label text-md-right col-md-2">dodaj zdjęcie:</label>
				<div class="col-md-8">
					<input name="path" type="file" class="form-control-file" id="path">
				</div>
			</div>
			@if($user->path != null)
				<div class="form-group row">
					<div class="offset-lg-2 col-md-3 col-sm-6">
	                    <img class="img-responsive" src="{{ asset("storage/$user->path") }}" width="140" height="100" alt="...">
	                </div>
	            </div>
			@endif
			<div class="form-group row">
				<label for="roles" class="col-form-label text-md-right col-md-2">role:</label>
				<div class="col-md-8">
					<select name="roles[]" id="roles[]" class="form-control">
						<option value=""></option>
						@foreach($roles as $role)
							<option value="{{ $role->id }}"
								{{-- @foreach($role->users as $roleUser)
									@if($roleUser->id === $user->id)
									selected
									@endif
								@endforeach --}}
								@if($role->users->contains($user->id))
								selected
								@endif>
								{{ $role->name }}
							</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-8 offset-md-2">
					<button type="submit" class="btn btn-block btn-danger">edytuj użytkownika - {{ $user->name }}</button>
				</div>
			</div>
		</form>
	</div>
@endsection
