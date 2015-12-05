<!-- resources/views/auth/login.blade.php -->

@extends('app')


@section('customStyles')
    <link href="css/signin.css" rel="stylesheet">
@stop


@section('content')

    @if(  Session::get('error'))
    <div>
      <span class="alert-info"> {{ Session::get('error') }}</span>
    </div>
    @endif
    <form class="form-signin"  method="POST" action="login/confirmation">
        <input type="hidden" name="_token" value="{!!  csrf_token()!!}">
        <h3 class="form-signin-heading" >Please Login</h3>
        <label for="nickname" class="sr-only">Nickname</label>
        <input type="text" name="nickname" id="nickname" class="form-control" value="{{ old('nickname') }}" placeholder="Nickname" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
    </form>

@stop

@section('customScripts')

@stop