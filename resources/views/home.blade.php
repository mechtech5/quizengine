@extends('layouts.app')

@section('content')
	<div class="container-fluid">
	  <game-component :logged_user="{{ json_encode(auth()->user()) }}"></game-component>
	</div>
@endsection
