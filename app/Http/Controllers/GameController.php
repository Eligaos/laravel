<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GameController extends Controller
{

    public function create(){
        $createGame = array(
            'gameName' => Input::get('gameName'),
            'gameOwner' => Auth::user()->username,
            'lines' => Input::get('lines'),
            'columns' => Input::get('columns'),
            'maxPlayers' => Input::get('maxPlayers'),
            'gameType' => Input::get('gameType'),
        );
        $gameCreated = Game::create($createGame);

        return $gameCreated;
        /*$input = Request::all();
        Article.create($input);
        return $input;*/
    }
}
