<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Game;
use Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class GameController extends Controller
{

    public function createRoom(Request $request){
        $createGame = array(
            'gameName' => Input::get('gameName'),
            'gameOwner' => Auth::user()->nickname,
            'lines' => Input::get('lines'),
            'columns' => Input::get('columns'),
            'maxPlayers' => Input::get('nrPlayers'),
            'joinedPlayers' => Input::get('nrBots'),
            'isPrivate' => Input::get('isPrivate'),
            'token' => Input::get('token'),
            'status' => "Waiting",
        );
        $gameCreated = Game::create($createGame);

        return Redirect::to('gameLobby');
        /*$input = Request::all();
        Article.create($input);
        return $input;*/
    }


    public function showGames(){
        $watingGames = Game::where('status','=',"Waiting")->get();
        dd($watingGames);
        return Redirect::to('gameLobby');
    }
}
