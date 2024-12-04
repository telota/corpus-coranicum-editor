@extends("layouts.master")

@section("title")

    @if(empty($user->name))
        Neuer Nutzer
    @else
        {{ $user->name }}
    @endif

@endsection

@section("content")

    {!! Form::model($user, array("action" => $action)) !!}

        <div class="form-group">
            <label for="name">Nutzername</label>
            {!! Form::text("name", $user->name, array("class" => "form-control")) !!}
        </div>

        <div class="form-group">
            <label for="email">E-Mail</label>
            {!! Form::email("email", $user->email, array("class" => "form-control")) !!}
        </div>

        <div class="form-group">
            <label for="role">Rolle</label>
            {!! Form::select("roles[]",
            App\Models\Role::all()->pluck('display_name','name')->toArray(),
            $user->roles->pluck('name')->toArray(),
            array('multiple' => 'multiple')) !!}
        </div>

        <div class="alert alert-info">
            Der neue Nutzer wird beim ersten Login dazu aufgefordert sein Passwort zu ändern.
        </div>


    {!! Form::Button('<i class="glyphicon glyphicon-save"></i> Speichern',
    array("class" => "btn btn-primary", "type" => "submit")) !!}

    {!! Form::close() !!}

@endsection