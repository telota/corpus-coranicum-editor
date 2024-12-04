@extends("layouts.master")

@section("title")

    <h1>{{ $koranstelle->germanKoranstelle }}</h1>
    <h3>{{ $koranstelle->readableKoranstelle }}</h3>

@endsection


@section("content")

    {!! Form::open(["action" => [[App\Http\Controllers\KoranController::class, 'update'], $koranstelle->sure, $koranstelle->vers, $koranstelle->wort]]) !!}

    <div class="panel panel-default">

        <div class="panel-heading">
            <h4>Koranstelle für {{ $koranstelle->readableKoranstelle }} - {{ $koranstelle->transkription }}</h4>
        </div>

        <div class="panel-body">

            <div class="form-group">
            {!! Form::text(
                "transcription",
                $koranstelle->transkription,
                ["class" => "form-control", "id" => "transcription"]) !!}
            </div>

        </div>

    </div>

    <hr>

    <div class="form-group">
        <button class="btn btn-primary">
            <span class="glyphicon glyphicon-save"></span> Speichern
        </button>
    </div>

    {!! Form::close() !!}

@endsection