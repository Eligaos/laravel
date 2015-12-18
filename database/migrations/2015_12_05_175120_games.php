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
            $table->increments('game_id');
            $table->string('gameName')->unique();
            $table->string('gameOwner');
           // $table->foreign('gameOwner')->references('nickname')->on('users');
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
            $table->primary(['game_id', 'user_id']);
            $table->integer('game_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('game_id')->references('game_id')->on('games');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('numberPairs');
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
        Schema::drop('game_player');
        Schema::drop('games');
    }
}
