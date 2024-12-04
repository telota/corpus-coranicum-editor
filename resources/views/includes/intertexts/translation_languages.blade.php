<div class="panel panel-default">

    <div class="panel-heading">
            <div class="panel-title">Translations</div>
    </div>



    <div class="panel-body">

        <h4>
            Translation
            <span class="label label-default">{{ 1 }}: (language) </span>
        </h4>
        <hr>
        <div class="panel panel-default">

            <div class="panel-body">

                <div>
        <span class="btn btn-primary btn-xs summernote-activator" summernote-target="#Originalsprache">
            <span class="glyphicon glyphicon-pencil"></span>
            Edit in Editor
        </span>
                </div>
                <br>
                <div>
                    {!! Form::textarea("intertext_translation", $record->translation_id, ["id" => "intertext_translation"]) !!}
                </div>

            </div>

        </div>


        <div class="btn btn-danger remove-image"><span class="glyphicon glyphicon-remove"></span> Translation entfernen</div>
        <hr>
    </div>

    <div class="panel-body space-between">
        <div>
            {!! Form::label("Language", "Language") !!}
            {!! Form::select(
                "Language",
                \App\Models\Intertexts\Intertext::getAllTranslationLanguages(false),
                $record->translation_id,
                [ "class" => "custom-select", "id" => "language"]
                ) !!}
        </div>

        <div class="btn btn-primary" id="add-image" route="umwelttexte"><span class="glyphicon glyphicon-plus"></span> Translation hinzufügen</div>

    </div>

</div>
