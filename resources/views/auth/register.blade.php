<!-- resources/views/auth/register.blade.php -->
@extends('app')


@section('customStyles')
    <link href="css/signin.css" rel="stylesheet">
@stop


@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form class="form-signin" method="POST" action="register/registration">
    <input type="hidden" name="_token" value="{!!  csrf_token()!!}">
    <h3 class="form-signin-heading" >Please Enter your Details</h3>

    <label for="nickname" class="sr-only">Email address</label>
    <input type="text" name="nickname" id="nickname" class="form-control" value="{{ old('nickname') }}" placeholder="Nickname" required autofocus>

    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Email address" required>

    <label for="password" class="sr-only">Password</label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>

    <label for="password_confirmation" class="sr-only">Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Password Confirmation" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
</form>

@stop

@section('customScripts')

@stop