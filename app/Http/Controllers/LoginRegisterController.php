<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;
use Hash;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Cookie as Cookie;

class LoginRegisterController extends Controller
{


    public function showLoginView()
    {

        if(count(Input::all()) > 0){
            Session::reflash();
        }
        return view('auth.login');
    }

    public function login()
    {
        $input = Input::except("_token");

        if(Auth::attempt(['nickname' => $input['nickname'], 'password' => $input['password']], Input::get('remember_token'))){
              return Redirect::to('gameLobby');
        }
        Session::flash('error', 'Login failed check your nickname and/or password');

        return Redirect::to('login');
    }


    public function showRegisterView()
    {
        return view('auth.register');
    }

    public function registerAccount(Requests\RegisterRequest $request)
    {
        User::createUser(Input::except("_token", "password_confirmation"));
        if(Auth::attempt(['nickname' => Input::get('nickname'), 'password' => Input::get('password')])){
               return Redirect::to('gameLobby');
         }
    }

    public function logout()
    {
        Auth::logout();
        $rememberMeCookie = Auth::getRecallerName();
        // Tell Laravel to forget this cookie
        $cookie = Cookie::forget($rememberMeCookie);


        return Redirect::to('/')->withCookie($cookie);
    }



}



