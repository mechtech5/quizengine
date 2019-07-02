@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <lobby-component :logged_user="{{ json_encode(auth()->user()) }}"></lobby-component>
        </div>
    </div>
</div>
@endsection
