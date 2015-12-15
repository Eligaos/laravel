<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    protected $table = 'games';

    protected $fillable = ['gameName', 'gameOwner','lines','columns','maxPlayers','joinedPlayers','isPrivate','status','winner','token'];

    public function players(){

        return $this->belongsToMany('App\Player', 'playerID')->get();

    }



}
