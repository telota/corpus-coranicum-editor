@extends("layouts.master")

@section("content")

    <form action="{{ action([App\Http\Controllers\Auth\RegisteredUserController::class, 'store') }}" class="form-signin" method="POST">
        {!! csrf_field() !!}

        <h2 class="form-signin-heading">Login</h2>

        <label for="name" class="sr-only">Name</label>
        <input name="name" type="name" id="inputName" class="form-control" value="{{ old("name") }}" placeholder="Name" required autofocus>

        <label for="inputEmail" class="sr-only">Email-Addresse</label>
        <input name="email" type="email" id="inputEmail" class="form-control" value="{{ old("email") }}" placeholder="Email-Addresse" required >

        <label for="inputPassword" class="sr-only">Passwort</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Passwort" required>

        <label for="confirmPassword" class="sr-only">Passwort wiederholen</label>
        <input name="password_confirmation" type="password" id="cornfirmPassword" class="form-control" placeholder="Passwort wiederholen" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Registrieren</button>
        <div class="text-right"><a href="{{ action([App\Http\Controllers\Auth\AuthenticatedSessinController::class, 'create']) }}">Einloggen</a></div>

    </form>


@stop