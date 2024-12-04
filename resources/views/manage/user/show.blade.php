@extends("layouts.master")

@section("title")

    <h1>{{ $user->name }}

        <a href="{{ URL::action([App\Http\Controllers\AdminController::class, 'edit'], $user->id) }}">
            <span class="glyphicon glyphicon-hover glyphicon-pencil"></span>
        </a>
    </h1>

@endsection

@section("content")

    <div>
        <li class="list-group-item">
            <span class="label label-default">Name</span> {{ $user->name }}
        </li>
        <li class="list-group-item">
            <span class="label label-default">E-Mail</span> {{ $user->email }}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Rollen</span>
            <ul>
            @foreach($user->roles as $role)
                <li>{{ $role->display_name }}</li>
            @endforeach
            </ul>
        </li>
    </div>

    <hr>

    {!! Form::model($user, array("action" => array([App\Http\Controllers\AdminController::class, 'setPasswordReset'], $user->id))) !!}

    {!! Form::hidden("id", $user->id) !!}

    {!! Form::Button('<i class="glyphicon glyphicon-warning-sign"></i> Passwort zurücksetzen',
    array("class" => "btn btn-warning", "type" => "submit")) !!}

    {!! Form::close() !!}


@endsection