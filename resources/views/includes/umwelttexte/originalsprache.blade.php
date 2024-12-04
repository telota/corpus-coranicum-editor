<div class="panel panel-default">




    <div class="panel-body">

        <div>
        <label for="Originalsprache">Originalsprache</label>
        <span class="btn btn-primary btn-xs summernote-activator" summernote-target="#Originalsprache">
            <span class="glyphicon glyphicon-pencil"></span>
            Edit in Editor
        </span>
        </div>

        {!! Form::textarea("Originalsprache", $record->Originalsprache, ["id" => "Originalsprache"]) !!}

    </div>

</div>