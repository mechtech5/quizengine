<?php

namespace App\Http\Controllers;

use App\User;
use App\Events\Ready;
use Illuminate\Http\Request;

class LobbyController extends Controller
{
  public function ready(User $user) {
		broadcast(new Ready($user))->toOthers();
	}
}
