@extends("layouts.master")

@section("title")

    <h1>
        Lesartkommentar zu Sure {{ $sure }}, Vers {{ $vers }}
    </h1>

@endsection

@section("content")

    {!! Form::open(array("action" => array([LeseartenController::class, 'kommentarUpdate']))) !!}

    @include("includes.forms.summernote", [
        "label" => "kommentar",
        "content" => $kommentar
    ])

    {!! Form::hidden("sure", $sure) !!}

    {!! Form::hidden("vers", $vers) !!}

    {!! Form::Button('<i class="glyphicon glyphicon-save"></i> Speichern',
        array("class" => "btn btn-primary", "type" => "submit")) !!}

    {!! Form::close() !!}

@endsection