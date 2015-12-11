<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Contracts\Factory as Socialite;

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
            // dd($user);
            return Redirect::to('gameLobby');


        }else{
            return 'something went wrong';
        }
    }


}
