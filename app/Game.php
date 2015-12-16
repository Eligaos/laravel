<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Game extends Model
{
    //
    protected $table = 'games';

    protected $fillable = ['gameName', 'gameOwner','lines','columns','maxPlayers','joinedPlayers','isPrivate','status','winner','token'];
    protected $primaryKey = 'game_id';

    public function players(){

        return $this->belongsToMany('App\Player', 'game_player', 'player_id', 'game_id');

    }

    public function attachPlayersToGame($player, $game_id){

        $this->players()->attach(['game_id' => $game_id], ['player_id' => $player->player_id]);

    }

    public static function prepareCreateGame($input){

        if($input['nrBots'] >= $input['nrPlayers']){
            $input['nrBots'] -= 1;
        }else{
            $input['nrBots'] += 1;
        }

        $createGame = array(
            'gameName' => $input['gameName'],
            'gameOwner' => Auth::user()->nickname,
            'lines' =>$input['lines'],
            'columns' => $input['columns'],
            'maxPlayers' => $input['nrPlayers'],
            'joinedPlayers' => $input['nrBots'],
            'isPrivate' => $input['isPrivate'],
            'token' => $input['token'],
            'status' => "Waiting",
        );

        return $createGame;
    }


}
