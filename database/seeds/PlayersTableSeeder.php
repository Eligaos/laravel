<?php

use Illuminate\Database\Seeder;
use \App\User as User;
use \App\Player as Player;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$faker = Faker::create('pt_PT');
        /*$userCount = User::all()->count();
        for ($i=0; $i < 5; $i++) {
            Player::insert(array(
                'player_id'=> rand(1,$userCount),
                'status'=> 'Waiting'
            ));
        }*/
    }
}
