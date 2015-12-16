<?php

namespace App\Http\Controllers;

use DebugBar\DebugBar;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Game;
use App\Player;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Tests\Input\InputTest;
use Input;

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
          $player = Player::find(Auth::user()->id);
           $games = [];
           if($player != null){
               $gamesT = $player->games()->get();
               foreach($gamesT as $t){
                   if($t->joinedPlayers == $t->maxPlayers){
                       array_push($games, $t);
                   }
               }
           }

          return view('gameLobby', compact('games'));

       }
    }

    public function listGames()
    {
        if(Auth::user()){
            $nickname = Auth::user()->nickname;

            //$title = "Utilizadores";
            // $users = User::paginate(10);
            $gamesWaiting = Game::where('status', 'LIKE', 'Waiting' )->orderBy('gameName', 'DESC')->get();
            $gamesPlaying = Game::where('status', 'LIKE', 'Playing' )->orderBy('gameName', 'DESC')->get();
            $gamesStarting = Game::where('status', 'LIKE', 'Starting')->where('gameOwner', 'LIKE', $nickname)->orderBy('gameName', 'DESC')->get();
            //  return view('guest_all.users-list', compact('users', 'title', 'featured'));
            //return view('gameLobby', compact('nickname', 'gamesWaiting', 'gamesPlaying'));
            return response()->json(['gamesPlaying' => $gamesPlaying, 'gamesWaiting' => $gamesWaiting, 'gamesStarting' => $gamesStarting]);
        }
    }


    public function joinGame()
    {
        $gameID = Input::all();
        $game = Game::find($gameID['id']);
        \Debugbar::info($game->joinedPlayers);
        if($game != null){
            if($game->joinedPlayers < $game->maxPlayers){
                $player = Player::createAndFind();
                $game->attachPlayersToGame($player, $gameID['id']);
                $game->joinedPlayers += 1;
                if($game->joinedPlayers == $game->maxPlayers){
                    $game->status = "Starting";

                }
                $game->save();
            }
        }

        return response()->json(['game' => $game]);
    }

    public function startGame($id)
    {

        \Debugbar::info($id);
        $game = Game::find($id);

        \Debugbar::info($game);
        if($game != null){
            $game->status = "Playing";
            $game->save();

        }

        return response()->json(['game' => $game]);
    }

}
