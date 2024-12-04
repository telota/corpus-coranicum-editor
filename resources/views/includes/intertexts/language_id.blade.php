<div class="panel panel-default">
    <div class="panel-heading">
        <span class="panel-title">Original Language</span>
    </div>

    <div class="panel-body space-between">

        <div>
        {!! Form::label("original_language", "Language") !!}
        {!! Form::select(
            "original_language",
            \App\Models\Intertexts\Intertext::getAllLanguages(false),
            $record->language_id ? \App\Models\Intertexts\OriginalLanguage::find($record->language_id)->original_language : "None",
            [ "class" => "custom-select", "id" => "language"]
            ) !!}

        </div>


        <div>

            {!! Form::label("language_direction", "Textrichtung") !!}
            {!! Form::select(
                "language_direction",
                [ "ltr" => "Links nach Rechts" , "rtl" => "Rechts nach Links"],
                $record->language_direction,
                [ "class" => "default-select", "id" => "language_direction"]

            ) !!}

        </div>


    </div>

    @include("includes.intertexts.source_text_original")

</div>
