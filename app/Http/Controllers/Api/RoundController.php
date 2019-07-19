<?php

namespace App\Http\Controllers\Api;

use App\Events\FriendIsHere;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Round;
use App\User;
use Illuminate\Http\Request;

class RoundController extends Controller
{
  // Creating a round for play
  public function create(User $user)
  {
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

  	$round = Round::create([
      'player_1' => $user->id,
      'code' => strtoupper(substr(str_shuffle($permitted_chars), 0, 6))
    ]);

    $round = Round::findOrFail($round->id);

  	return response()->json($round, 201);
  }

  public function join(User $user)
  {
    $res = array();
    $vdata = request()->validate([
      'code' => 'required'
    ]);

    $round = Round::where('code', $vdata['code'])->where('status', 0)->first();
    $round->player_2 = $user->id;
    $round->status = 1;
    $round->save();
    
    broadcast(new FriendIsHere())->toOthers();

    $res['round'] = $round;
    $res['opponent'] = User::where('id', $round->player_1)->first();
    $res['questions'] = Question::where('topic_id', $round->topic_id)->get();

    return response()->json($res, 200);
  }

  public function show(Round $round) {
    return response()->json($round, 200);
  }

  public function start(Round $round) {
    $res = array();
    $res['round'] = $round;
    $res['opponent'] = User::where('id', $round->player_2)->first();
    $res['questions'] = Question::where('topic_id', $round->topic_id)->get();

    return response()->json($res, 200);
  }
}
