<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \App\Game as Game;
use \App\User as User;
class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $faker = Faker::create('pt_PT');
      /*  $usersNick[] = User::lists('nickname');
        $userCount = User::all()->count();
        $max_nicks = count($usersNick);*/
        for ($i=0; $i < 5; $i++) {
                Game::insert(array(
                    'gameName' => $faker->numerify('Game ###'),
                   //'gameOwner' => $faker->randomElement($usersNick),
                    'gameOwner' => $faker->lastName,
                    'lines' => $faker->numberBetween(2,10),
                    'columns' => $faker->numberBetween(2,10),
                    'maxPlayers' => $faker->numberBetween(2,10),
                    'joinedPlayers' => $faker->numberBetween(0,2),
                    'isPrivate' => 0,
                    'status' => 'Waiting',
                    'winner' => null,
                ));
            }

        for ($i=0; $i < 5; $i++) {
            Game::insert(array(
                'gameName' => $faker->numerify('Game ###'),
                'gameOwner' =>$faker->lastName,
                'lines' => $faker->numberBetween(2,10),
                'columns' => $faker->numberBetween(2,10),
                'maxPlayers' => 5,
                'joinedPlayers' => 5,
                'isPrivate' => 0,
                'status' => 'Playing',
                'winner' => null,
            ));
        }
    }

}
