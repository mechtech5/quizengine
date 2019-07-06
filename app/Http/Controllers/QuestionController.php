<?php

namespace App\Http\Controllers;

use App\Models\Question;

class QuestionController extends Controller
{
  public function index() {
  	$questions = Question::all();
  	return view('question.index', compact('questions'));
  }

  public function create() {
  	return view('question.create');
  }

  public function store()
  {
  	// return request()->all();
  	$validated_data = request()->validate([
  		'topic_id' => ['required'],
  		'ques' => ['required'],
  		'options' => ['required'],
  		'ans' => ['required']
  	]);

  	// $question = Question::create(request()->all());
  	$question = Question::create($validated_data);

  	return response()->json($question, 201);
  }
}
