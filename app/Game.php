<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Eloquent
{
    //
 //   protected $table = 'games';

    protected $fillable = ['gameName', 'gameOwner','lines','columns','maxPlayers','joinPlayers','gameType','winner'];
}
