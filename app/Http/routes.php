<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// Authentication routes...
Route::get('/', 'LoginRegisterController@showLoginView');


Route::get('game', function () {
    return view('game');
});



/*Route::get('gameLobby', function () {
    echo("User".Auth::user());
    //return view('gameLobby');
});*/
Route::get('gameLobby', 'GameLobbyController@lobby');


// Authentication routes...
Route::any('login', 'LoginRegisterController@showLoginView');
Route::post('login/confirmation', ['as' => 'login-confirm', 'uses' => 'LoginRegisterController@login']);
Route::post('gameLobby/createRoom', ['uses' => 'GameController@createRoom']);
//Route::get('gameLobby/showGames', ['uses' => 'GameController@showGames']);
Route::get('gameLobby/startGame/{id}', ['uses' => 'GameLobbyController@startGame']);

Route::get('gameLobby/listGames', ['uses' => 'GameLobbyController@listGames']);

// Registration routes...
Route::any('register', ['as' => 'form-register', 'uses' => 'LoginRegisterController@showRegisterView']);

Route::any('register/registration', ['as' => 'form-register', 'uses' => 'LoginRegisterController@registerAccount']);

Route::any('logout', ['as' => 'logout', 'uses' => 'LoginRegisterController@logout']);

Route::post('gameLobby/joinGame', ['uses' => 'GameLobbyController@joinGame']);
Route::post('gameLobby/viewGame', ['uses' => 'GameLobbyController@viewGame']);

//Social Login
Route::get('/login/{provider?}',[
    'uses' => 'SocialiteController@getSocialAuth',
    'as'   => 'auth.getSocialAuth'
]);


Route::get('/login/callback/{provider?}',[
    'uses' => 'SocialiteController@getSocialAuthCallback',
    'as'   => 'auth.getSocialAuthCallback'
]);