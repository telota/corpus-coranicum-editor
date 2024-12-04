<div class="panel panel-default">
    <div class="panel-heading">
        <span class="panel-title">Translation Language</span>
    </div>

    <div class="panel-body space-between">

        <div>
        {!! Form::label("language_id", "Language") !!}
        {!! Form::select(
            "language_id",
            \App\Models\GeneralCC\TranslationLanguage::getAllLanguages(false),
            $record->language_id,
            [ "class" => "custom-select", "id" => "language"]
            ) !!}

        </div>


    </div>
</div>
