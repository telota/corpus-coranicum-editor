<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title">{{ ucfirst('tuk_reference') }}
            <span href="#" data-toggle="tooltip" title="Who has discovered this text as relevant for the Qurʾān?">
                <i class="fa fa-info-circle" style="color: #2e6da4" aria-hidden="true"></i>
            </span>
            <span class="btn btn-primary btn-xs summernote-activator" summernote-target="#tuk_reference">
            <span class="glyphicon glyphicon-pencil"></span>
            Edit in Editor
        </span>
        </div>
    </div>

    <div class="panel-body">

        <div class="form-group">
            {!! Form::textarea($label, $content, array("class" => "", "id" => "tuk_reference")) !!}
        </div>

    </div>

</div>
