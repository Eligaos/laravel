<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Game;
use Illuminate\Support\Facades\Auth;

class GameLobbyController extends Controller
{
    public function lobby()
    {
       if(Auth::user()){
           $nickname = Auth::user()->nickname;
           \Debugbar::info(Auth::getRecallerName());
          //$title = "Utilizadores";
          // $users = User::paginate(10);
         //  $gamesWaiting = Game::where('status', 'LIKE', 'Waiting' )->orderBy('gameName', 'DESC')->get();
        //   $gamesPlaying = Game::where('status', 'LIKE', 'Playing' )->orderBy('gameName', 'DESC')->get();
         //  return view('guest_all.users-list', compact('users', 'title', 'featured'));
         //  return view('gameLobby', compact('nickname', 'gamesWaiting', 'gamesPlaying'));
          return view('gameLobby');

       }
    }

    public function listGames()
    {
        if(Auth::user()){
            $nickname = Auth::user()->nickname;
            \Debugbar::info(Auth::getRecallerName());
            //$title = "Utilizadores";
            // $users = User::paginate(10);
            $gamesWaiting = Game::where('status', 'LIKE', 'Waiting' )->orderBy('gameName', 'DESC')->get();
            $gamesPlaying = Game::where('status', 'LIKE', 'Playing' )->orderBy('gameName', 'DESC')->get();
            //  return view('guest_all.users-list', compact('users', 'title', 'featured'));
            //return view('gameLobby', compact('nickname', 'gamesWaiting', 'gamesPlaying'));
            return response()->json(['gamesPlaying' => $gamesPlaying, 'gamesWaiting' => $gamesWaiting]);
        }
    }


}
