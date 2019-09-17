@extends('layouts.app')
@section('title','formularz kontaktowy')
@section('content')
	<div class="jumbotron bg-dark text-white">
		<h2>Formularz kontaktowy</h2>
	</div>
	@include('error')
	@include('session')
	<div class="jumbotron bg-dark text-white">
		<form {{ $novalidate }} action="{{ route('sendContact') }}" method="post">
			<div class="form-group row">
				<label for="email" class="col-form-label text-md-right col-md-2">email:</label>
				<div class="col-md-8">
					<input type="text" name="email" class="form-control" value="{{ old('email') }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="subject" class="col-form-label text-md-right col-md-2">temat:</label>
				<div class="col-md-8">
					<input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="message" class="col-form-label text-md-right col-md-2">treść:</label>
				<div class="col-md-8">
					<textarea name="message" id="message" class="form-control" cols="30" rows="10">{{ old('message') }}</textarea>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-8 offset-md-2">
					<button type="submit" class="btn btn-block btn-outline-success">wyślij</button>
				</div>
			</div>
			{{ csrf_field() }}
		</form>
	</div>
@endsection
