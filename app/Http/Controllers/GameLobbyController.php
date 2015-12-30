<?php

namespace App\Http\Controllers;

use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Game;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Tests\Input\InputTest;
use Input;
use DB;
use Session;

class GameLobbyController extends Controller
{
    public function lobby()
    {
        if (Auth::user()) {
            $nickname = Auth::user()->nickname;
            //$title = "Utilizadores";
            // $users = User::paginate(10);
            //  $gamesWaiting = Game::where('status', 'LIKE', 'Waiting' )->orderBy('gameName', 'DESC')->get();
            //   $gamesPlaying = Game::where('status', 'LIKE', 'Playing' )->orderBy('gameName', 'DESC')->get();
            //  return view('guest_all.users-list', compact('users', 'title', 'featured'));
            //  return view('gameLobby', compact('nickname', 'gamesWaiting', 'gamesPlaying'));
            //  $player = Player::find(Auth::user()->id);
            // $games = [];
            //  if($player != null){
            $games = Auth::user()->games()->where('status', 'LIKE', 'Playing')->get();
            /* foreach($gamesT as $t){
                  if($t->joinedPlayers == $t->maxPlayers){
                      array_push($games, $t);
                  }
              }*/
            //    }
            if (count(Input::all()) > 0) {
                Session::reflash();
            }

            return view('gameLobby', compact('games'));

        }
    }

    public function listGames()
    {
        if (Auth::user()) {
            $nickname = Auth::user()->nickname;
            //$title = "Utilizadores";
            // $users = User::paginate(10);

            //FAZER PARA OS TOKENS!!

            $gamesWaiting = Game::where('status', 'LIKE', 'Waiting')->where('isPrivate', '=', 0)->orderBy('gameName', 'DESC')->get();
            $gamesPlaying = Game::where('status', 'LIKE', 'Playing')->where('isPrivate', '=', 0)->orderBy('gameName', 'DESC')->get();
            //  return view('guest_all.users-list', compact('users', 'title', 'featured'));
            //return view('gameLobby', compact('nickname', 'gamesWaiting', 'gamesPlaying'));
            return response()->json(['gamesPlaying' => $gamesPlaying, 'gamesWaiting' => $gamesWaiting]);
        }
    }


    public function joinGame()
    {
        $gameID = Input::all();
        if ($gameID['id'] == -1) {
            $game = Game::where('token','NOT LIKE', "")->where('token', '=', $gameID['token'])->first();
           $error = $this->insertInGame($game);
        } else {
            $game = Game::find($gameID['id']);
            $error = $this->insertInGame($game);
        }
        return response()->json(['game' => $game, 'error' => $error]);

    }

    public function insertInGame($game)
    {
        if ($game != null) {
            if ($game->joinedPlayers < $game->maxPlayers) {
                $user = Auth::user()->user;

                $game->attachPlayersToGame($user);
                $game->joinedPlayers += 1;
                if ($game->joinedPlayers == $game->maxPlayers) {
                    $game->status = "Playing";
                }
                $game->save();
            }
            return "Joined";
        }
        return "Game with this token not found";
    }

    public function startGame($id)
    {
        \Debugbar::info($id);
        $game = Game::find($id);
        //  $players = DB::select( DB::raw("SELECT game_id FROM game_player gp join games g on gp.game_id = g.game_id join players p on gp.player_id = p.player_id"));

        //   \Debugbar::info($players);
        if ($game != null) {
            /*   for($i=0; i<$players; $i++){
                   $players->status = "Playing";
                   $players->save();
               }*/

            $game->status = "Playing";
            $game->save();
        }

        return response()->json(['game' => $game]);
    }

    public function endGame()
    {
        $vars = Input::all();
        $game = Game::find($vars['id']);
        $game->status = "Finished";
        $game->winner = $vars['winner'];
        $game->save();
    }


}
