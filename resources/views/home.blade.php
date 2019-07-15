@extends('layouts.app')

@section('content')
	<div class="container-fluid">
	  <lobby-component :logged_user="{{ json_encode(auth()->user()) }}"></lobby-component>
	</div>
@endsection
