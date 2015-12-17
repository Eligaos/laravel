<?php

use Illuminate\Database\Seeder;



class GamePlayerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
           /* Player::insert(array(
            $table->primary(['game_id', 'player_id']);
            $table->integer('game_id')->unsigned();
            $table->integer('player_id')->unsigned();
            $table->foreign('game_id')->references('game_id')->on('games');
            $table->foreign('player_id')->references('player_id')->on('players');
            $table->integer('numberPairs');
            $table->double('timePlaying', 4, 4);
            $table->timestamps()
           ;)*/
        }
    }
}
