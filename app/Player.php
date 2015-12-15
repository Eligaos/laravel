<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'players';

    protected $fillable = ['playerID', 'status'];

    public function games(){

        return $this->belongsToMany('App\Game', 'playerID')->get();

    }

}
