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
    protected $primaryKey = "id";

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
        if(count($input) > 0){
            $user = User::validateUser($input);
            if(is_object($user)) {

            echo("User".Auth::user());
             return Redirect::to('gameLobby');
            }
        }
        Session::flash('error', $user);

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


    }



}



