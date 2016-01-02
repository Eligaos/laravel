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
        if(Game::where('gameName','=',$createGame['gameName'])->where('status', 'not like', 'Finished')->first() != null) {

            return Redirect::to('gameLobby')->with('message', 'Game Already Exists!');

        }
        $gameCreated = Game::create($createGame);
        $gameCreated->attachPlayersToGame();
        if($gameCreated->joinedPlayers == $gameCreated->maxPlayers){
            $gameCreated->status= "Playing";
            $gameCreated->save();
        }

        return Redirect::to('gameLobby')->with('message', 'Game Created!');
    }


    /*public function showGames(){
        $watingGames = Game::where('status','=',"Waiting")->get();
        dd($watingGames);
        return Redirect::to('gameLobby');
    }*/
}
