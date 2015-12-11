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
            //$table->engine="InnoDB";
            $table->increments('id');
            $table->string('gameName')->unique();
            $table->string('gameOwner');
            $table->integer('lines');
            $table->integer('columns');
            $table->integer('maxPlayers');
            $table->integer('joinedPlayers');
            $table->boolean('gameType');
            $table->string('winner')->nullable();
            $table->string('token');
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
    }
}
