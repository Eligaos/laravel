<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Contracts\Factory as Socialite;
use App\User;
use Illuminate\Support\Facades\Auth as Auth;

class SocialiteController extends Controller
{

    public function __construct(Socialite $socialite){
        $this->socialite = $socialite;
    }


    public function getSocialAuth($provider=null)
    {
        if(!config("services.$provider")) abort('404'); //just to handle providers that doesn't exist

        return $this->socialite->with($provider)->redirect();
    }


    public function getSocialAuthCallback($provider=null)
    {
        if($user = $this->socialite->with($provider)->user()){

            $authUser = $this->findOrCreateUser($user);

            Auth::login($authUser, true);

            // dd($user);
            return Redirect::to('gameLobby');

        }else{
            return 'something went wrong';
        }
    }

    private function findOrCreateUser($facebookUser)
    {

        $authUser = User::where('facebook_id', $facebookUser->id)->first();

        if ($authUser){
            return $authUser;
        }

        return User::create([
            'nickname' => $facebookUser->name,
            'email' => $facebookUser->email,
            'facebook_id' => $facebookUser->id
        ]);
    }

}
