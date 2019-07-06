@extends('layouts.app')

@section('content')
	<div class="container">
		<a href="{{ route('question.create') }}" class="btn btn-primary">Create</a>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Question</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($questions as $row)
				<tr>
					<td>{{ $row->id }}</td>
					<td>{{ $row->ques }}</td>
					<td>
						<a href="{{ route('question.show', $row->id) }}"><i class="fa fa-eye"></i></a>
						<a href="{{ route('question.edit', $row->id) }}"><i class="fa fa-edit"></i></a>
						<a href="#" onclick="event.preventDefault(); if(confirm('Are you sure?')){document.getElementById('delete-form-{{$row->id}}).submit();')}"><i class="fa fa-trash"></i></a>
						<form id="delete-form-{{$row->id}}" action="{{ route('question.destroy', $row->id) }}" class="d-none">
							@csrf
							@method('delete')
						</form>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection