<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \App\Game as Game;
class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $faker = Faker::create('pt_PT');
        for ($i=0; $i < 5; $i++) {
                Game::insert(array(
                    'gameName' => $faker->numerify('Game ###'),
                    'gameOwner' => 'user'.$i,
                    'lines' => $faker->numberBetween(2,10),
                    'columns' => $faker->numberBetween(2,10),
                    'maxPlayers' => $faker->numberBetween(2,10),
                    'joinedPlayers' => $faker->numberBetween(0,2),
                    'isPrivate' => 'user'.$i,
                    'status' => 'Waiting',
                    'winner' => null,
                ));
            }

        for ($i=0; $i < 5; $i++) {
            Game::insert(array(
                'gameName' => $faker->numerify('Game ###'),
                'gameOwner' => 'user'.$i,
                'lines' => $faker->numberBetween(2,10),
                'columns' => $faker->numberBetween(2,10),
                'maxPlayers' => 5,
                'joinedPlayers' => 5,
                'isPrivate' => 'user'.$i,
                'status' => 'Playing',
                'winner' => null,
            ));
        }
        }

}
