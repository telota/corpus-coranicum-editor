@extends("layouts.master")

@section("title")

    <h1>Paret-Übersetzung (Sure {{ $translations[0]->sure }}, Vers {{ $translations[0]->vers }})</h1>

@endsection

@section("content")

    {!! Form::open(["action" => [[DruckausgabeController::class, 'updateByVerse'], $translations[0]->sure, $translations[0]->vers]]) !!}

    @foreach( $translations as $translation )

        <div class="panel panel-default">

            <div class="panel-heading">
                <h4>Sprache: {{ $translation->sprache }}</h4>
            </div>

            <div class="panel-body">

                <div class="form-group">
                    {!! Form::text(
                        $translation->sprache . '_text',
                        $translation->text,
                        ["class" => "form-control", "id" => $translation->sprache]) !!}
                </div>

            </div>

        </div>

        <hr>

        {{--
        @include("includes.create_update", array(
            "record" => $tanzilTranslation,
            "action" => $actions[$tanzilTranslation->sprache]
        ))
        --}}

    @endforeach

    <div class="form-group">
        <button class="btn btn-primary">
            <span class="glyphicon glyphicon-save"></span> Speichern
        </button>
    </div>

    {!! Form::close() !!}

@endsection
