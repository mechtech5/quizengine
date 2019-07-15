@extends('layouts.app')

@section('content')
	<div class="container">
		<a href="{{ route('questions.create') }}" class="btn btn-primary">Create</a>
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr class="text-center">
					<th>#</th>
					<th>Question</th>
					<th>Options</th>
					<th>Answer</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($questions as $row)
				<tr class="text-center">
					<td>{{ $row->id }}</td>
					<td>{{ $row->ques }}</td>
					<td>
						@php
							$opts = json_decode($row->options);
							foreach($opts as $k=>$v):
								echo '('.strtoupper($k) .') '. $v. '<br>';
							endforeach;
						@endphp
					</td>
					<td>{{ strtoupper($row->ans) }}</td>
					<td>
						<a href="{{ route('questions.show', $row->id) }}"><i class="fa fa-eye fa-lg"></i></a>
						<a href="{{ route('questions.edit', $row->id) }}" class="ml-2"><i class="text-secondary fa fa-edit fa-lg"></i></a>
						<a href="#" onclick="event.preventDefault(); if(confirm('Are you sure?')){document.getElementById('delete-form-{{$row->id}}).submit();')}" class="ml-2"><i class="text-danger fa fa-trash fa-lg"></i></a>
						<form id="delete-form-{{$row->id}}" action="{{ route('questions.destroy', $row->id) }}" class="d-none">
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