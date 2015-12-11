<!-- resources/views/auth/login.blade.php -->

@extends('app')


@section('customStyles')
    <link href="css/signin.css" rel="stylesheet">
@stop


@section('content')

    @if( Session::get('error'))
        <div style="text-align: center">
            <span class="alert alert-info"> {{ Session::get('error') }}</span>
        </div>
    @endif
    <div style="text-align: center">
        <span style="font-weight: bold">Please Login</span> <span>Or</span>
       <a href="/register"><button class="btn btn-xs btn-primary " type="submit">Register</button></a>
    </div>


    <form class="form-signin" method="POST" action="login/confirmation">
        <input type="hidden" name="_token" value="{!!  csrf_token()!!}">


        <label for="nickname" class="sr-only">Nickname</label>
        <input type="text" name="nickname" id="nickname" class="form-control" value="{{ old('nickname') }}"
               placeholder="Nickname" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember_token" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>

        <div style="text-align: center; padding-top: 2%">

                <span style="font-weight: bold">Or Login with:</span>
        </div>
        <div id="social-login">
            <a href="/login/facebook"><button class="btn btn-xs btn-primary" type="button">face</button></a>

        </div>
    </form>

@stop

@section('customScripts')

@stop