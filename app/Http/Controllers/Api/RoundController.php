<?php

namespace App\Http\Controllers\Api;

use App\Events\FriendIsHere;
use App\Models\Round;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    $vdata = request()->validate([
      'code' => 'required'
    ]);

    $round = Round::where('code', $vdata['code'])->where('status', 0)->first();
    if($round)
    {
      $round->player_2 = $user->id;
      $round->status = 1;
      $round->save();

      broadcast(new FriendIsHere($user))->toOthers();

      return response()->json($round, 200);
    }
    else
    {
      return 'Not Found';
    }
  }
}
