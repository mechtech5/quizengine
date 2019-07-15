<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;

class QuestionController extends Controller
{
  public function index($topic_id) {
  	$questions = Question::all();
  	return response()->json($questions, 200);
  }

  public function show(Question $question) {
    return response()->json($question, 200);
  }

}
