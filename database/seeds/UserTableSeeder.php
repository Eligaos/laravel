<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \App\User as User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('pt_PT');

        User::insert(array(
            'nickname' => "user",
            'email' => "user@gmail.com",
            'password' => bcrypt("123"),
            'remember_token' => str_random(10),
        ));


        for ($i=0; $i < 5; $i++) {
            User::insert(array(
                'nickname' => $faker->unique()->numerify('User ###'),
                'email' => $faker->email,
                'password' => bcrypt("123")
            ));
        }
    }
}
