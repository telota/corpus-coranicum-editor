<div class="panel panel-default">

    <div class="panel-heading">
        <h4>Sprache</h4>
    </div>

    <div class="panel-body space-between">

        <div>
        {!! Form::label("Sprache", "Sprache") !!}
        {!! Form::select(
            "Sprache",
            \App\Models\Umwelttexte\Belegstelle::getAllLanguages(false),
            $record->Sprache,
            [ "class" => "custom-select", "id" => "sprache"]
            ) !!}

        </div>


        <div>

            {!! Form::label("Sprache_richtung", "Textrichtung") !!}
            {!! Form::select(
                "Sprache_richtung",
                [ "ltr" => "Links nach Rechts" , "rtl" => "Rechts nach Links"],
                $record->Sprache_richtung,
                [ "class" => "default-select", "id" => "sprache-richtung"]

            ) !!}

        </div>


    </div>

    @include("includes.umwelttexte.originalsprache")

</div>