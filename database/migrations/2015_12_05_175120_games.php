<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Games extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('gameID');
            $table->string('gameName')->unique();
            $table->string('gameOwner');
            $table->integer('lines');
            $table->integer('columns');
            $table->integer('maxPlayers');
            $table->integer('joinedPlayers');
            $table->boolean('isPrivate');
            $table->string('status');
            $table->string('winner')->nullable();
            $table->string('token')->nullable();
            $table->timestamps();
        });

        Schema::create('game_player', function (Blueprint $table) {

            $table->primary(['gameID', 'playerID']);
            $table->integer('playerID')->unsigned();
            $table->integer('gameID')->unsigned();
            $table->foreign('gameID')->references('gameID')->on('games');
            $table->foreign('playerID')->references('playerID')->on('players');
            $table->double('timePlaying',4,4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::drop('games');
       Schema::drop('game_player');

    }
}
