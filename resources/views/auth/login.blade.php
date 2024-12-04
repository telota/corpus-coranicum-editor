@extends('layouts.master')

@section('content')

    <form action="{{ route('store-login') }}" class="form-signin" method="POST">
        {!! csrf_field() !!}

        <h2 class="form-signin-heading">Login</h2>

        <label for="inputEmail" class="sr-only">Email-Addresse</label>
        <input name="email" type="email" id="inputEmail" class="form-control" value="{{ old('email') }}"
            placeholder="Email-Addresse" required autofocus>

        <label for="inputPassword" class="sr-only">Passwort</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Passwort" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Einloggen</button>


    </form>



@stop
