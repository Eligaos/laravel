<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Game;

use Input;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class GameController extends Controller
{

    public function createRoom(Request $request){

        $createGame = Game::prepareCreateGame(Input::all());
        $gameCreated = Game::create($createGame);

        $gameCreated->attachPlayersToGame();

        return Redirect::to('gameLobby');
    }


    /*public function showGames(){
        $watingGames = Game::where('status','=',"Waiting")->get();
        dd($watingGames);
        return Redirect::to('gameLobby');
    }*/
}
