<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class Game extends Model
{
    //
    protected $table = 'games';
    protected $fillable = ['gameName', 'gameOwner','lines','columns','maxPlayers','joinedPlayers','isPrivate','status','winner','token'];
    protected $primaryKey = 'game_id';

    public function users(){

        return $this->belongsToMany('App\User', 'game_player')->withPivot(['numberPairs','timePlaying'])->withTimestamps();

    }

    public function attachPlayersToGame(){
        $this->users()->attach( Auth::user()->id);
     /*   $joinedPlayers = $this->users()->count();

        if ($joinedPlayers == $this->maxPlayers){
            $this->status = "Starting";
            $this->save();
        }*/
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
