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
