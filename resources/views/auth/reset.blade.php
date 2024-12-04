@extends("layouts.master")

@section("title")

    <h1>Passwort zurücksetzen</h1>

@endsection

@section("content")

    <form action="{{ URL::action([App\Http\Controllers\UserController::class, 'postReset']) }}" class="form-signin" method="POST">
        {!! csrf_field() !!}

        <h2 class="form-signin-heading">Login</h2>

        <li class="list-group-item">
            {{ $user->name }}
        </li>

        <li class="list-group-item">
            {{ $user->email }}
        </li>

        <label for="inputPassword" class="sr-only">Neues Passwort</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Passwort" required>

        <label for="confirmPassword" class="sr-only">Neues Passwort wiederholen</label>
        <input name="password_confirmation" type="password" id="cornfirmPassword" class="form-control" placeholder="Passwort wiederholen" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Bestätigen</button>


    </form>

@endsection
