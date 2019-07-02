@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Lobby</div>

                <div class="card-body">
                    <lobby-component :logged_user="{{ json_encode(auth()->user()) }}"></lobby-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
