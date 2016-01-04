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
        if(Game::where('gameName','=',$createGame['gameName'])->first() != null) {

            return Redirect::to('gameLobby')->with('message', 'Game Already Exists!');

        }
        $user = Auth::user()->id;

        $gameCreated = Game::create($createGame);
        $gameCreated->attachPlayersToGame();
        $player = User::findOrFail($user);
        $relation = $player->games->find($gameCreated['game_id']);

        $relation->pivot->isPlayer=1;
        if($gameCreated->joinedPlayers == $gameCreated->maxPlayers){
            $gameCreated->status= "Playing";
        }
        $relation->pivot->save();
        $gameCreated->save();
        return Redirect::to('gameLobby')->with('message', 'Game Created!');
    }


    /*public function showGames(){
        $watingGames = Game::where('status','=',"Waiting")->get();
        dd($watingGames);
        return Redirect::to('gameLobby');
    }*/
}
