<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title">Script Language</div>
    </div>

    <div class="panel-body">

        {!! Form::select(
            "script_language",
            \App\Models\Intertexts\Intertext::getAllScripts(false),
            $record->script_id ? \App\Models\Intertexts\Script::find($record->script_id)->script : "None",
            [ "class" => "custom-select", "id" => "script"]
            ) !!}

    </div>

</div>
