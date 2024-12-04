<div class="panel panel-default">

    <div class="panel-body">

        <div>
        <label for="source_text_original">Source Text Original</label>
        <span class="btn btn-primary btn-xs summernote-activator" summernote-target="#source_text_original">
            <span class="glyphicon glyphicon-pencil"></span>
            Edit in Editor
        </span>
        </div>

        {!! Form::textarea("source_text_original", $record->source_text_original, ["id" => "source_text_original"]) !!}

    </div>

</div>
