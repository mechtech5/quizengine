<?php

namespace App\Http\Controllers;

use App\Events\Ready;
use App\Events\Unready;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function ready(User $user)
    {
      broadcast(new Ready($user))->toOthers();
    }

    public function unready(User $user)
    {
      broadcast(new Unready($user))->toOthers();
    }

    public function getPlayerDetails(User $user)
    {
        $req = request('req');
        return $user->name;
    }
}
