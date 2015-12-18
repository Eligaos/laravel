<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\Auth;

class Player extends Model
{
    protected $table = 'players';
    protected $primaryKey = 'player_id';
    protected $fillable = ['player_id', 'status'];

    public function games(){
        return $this->belongsToMany('App\Game', 'game_player')->withPivot(['numberPairs','timePlaying'])->withTimestamps();
    }

    public function user(){
        return $this->belongsTo('App\User');
    }


    public static function createPlayer(){
        $user = User::find(Auth::user()->id)->first();
        $createPlayer = array(
            'player_id' => $user->id,
            'status' =>"Waiting",
        );
        return Player::create($createPlayer);
    }

    public static function createAndFind(){
        if($player = Player::find(Auth::user()->id) == null){
            Player::createPlayer();
        }
        return Player::find(Auth::user()->id);
    }
}
