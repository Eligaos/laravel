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

class LoginRegisterController extends Controller
{


    public function showLoginView()
    {
        \Debugbar::info(Auth::user());
        if(count(Input::all()) > 0){
            Session::reflash();
        }
        return view('auth.login');
    }

    public function login()
    {
        $input = Input::except("_token");

        if(Auth::attempt(['nickname' => $input['nickname'], 'password' => $input['password'] ])){
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
        return Redirect::to('gameLobby');
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }



}



