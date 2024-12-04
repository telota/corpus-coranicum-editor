<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title">{{ ucfirst($label) }}
        <span class="btn btn-primary btn-xs summernote-activator" summernote-target="#{{ str_replace(" ", "_", $label) }}">
            <span class="glyphicon glyphicon-pencil"></span>
            Edit in Editor
        </span>
        </div>
    </div>

    <div class="panel-body">

        <div class="form-group">
            {!! Form::textarea($label, $content, array("class" => "", "id" => str_replace(" ", "_", $label))) !!}
        </div>

    </div>

</div>


