<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('questions/{topic_id}', 'Api\QuestionController@index');
Route::get('questions/{question}', 'Api\QuestionController@show');

Route::post('rounds/create/{user}', 'Api\RoundController@create');
Route::post('rounds/join/{user}', 'Api\RoundController@join');
Route::get('rounds/{round}', 'Api\RoundController@show');
Route::post('rounds/start/{round}', 'Api\RoundController@start');
Route::get('users/{user}', 'Api\UsersController@show');
