@extends('layouts.app')
@section('title','użytkownicy')
@section('content')
	<div class="jumbotron bg-dark text-white">
		<h2>Lista użytkowników</h2>
		<h5>ilość: <span class="badge badge-warning badge-pill">{{ $users->count() ?? null }}</span></h5>
	</div>
	@include('session')
	<table  class="table table-hover bg-dark text-white mb-4">
		<thead>
			<tr>
				<th>l.p.</th>
				<th class="col-md-8">imię i nazwisko</th>
				<th>profil</th>
				<th>edytuj</th>
				<th>usuń</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $key=>$user)
				<tr>
					<td>{{ $key + 1 }}</td>
					<td><a href="{{ route('users.show',$user->id) }}"><img src="{{ $user->path != null ? asset("storage/{$user->path}") : $placeholder }}" width="25" height="30" title="{{ $user->name }}" alt=""></a> {{ $user->name }}</td>
					<td><a href="{{ route('users.show',$user->id) }}" class="btn btn-sm btn-success"><i class="fas fa-info"></i></a></td>
					<td><a href="{{ route('users.edit',$user->id) }}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a></td>
					<td>
						<form action="{{ route('users.destroy',$user->id) }}" method="post">
							{{ method_field('delete') }}
							{{ csrf_field() }}
							<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('czy na pewno chcesz usunąć użytkownika: {{ $user->name }}')"><i class="far fa-trash-alt"></i></button>
						</form>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection
