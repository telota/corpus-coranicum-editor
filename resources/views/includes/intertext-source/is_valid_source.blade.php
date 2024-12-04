<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title">Is the source information text priority?
            <span href="#" data-toggle="tooltip" title="Will you show the information text of this source instead of the information text of this source author?">
                <i class="fa fa-info-circle" style="color: #2e6da4" aria-hidden="true"></i>
            </span>
        </div>
    </div>

    <div class="panel-body space-between">
        <span class="input-group">
            {!! Form::label($label, "yes") !!} &nbsp;
                {!! Form::radio(
                    $label,
                    true,
                    $record->$label === true
                ) !!}
        </span>
        <span class="input-group">
            {!! Form::label($label, "no") !!} &nbsp;
                {!! Form::radio(
                    $label,
                    false,
                    $record->$label === false
                ) !!}
        </span>
    </div>
</div>
