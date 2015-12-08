<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class GameLobbyController extends Controller
{
    public function lobby()
    {
       if(Auth::user()){

           $user = Auth::user();
           \Debugbar::info(Auth::getRecallerName());

           return view('gameLobby')->with('nickname', $user['nickname']);
       }

    }


}
