<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title">{{ ucfirst($label) }}</div>
    </div>

    <div class="panel-body space-between">
        <span class="input-group">
            {!! Form::label($label, "yes") !!} &nbsp;
                {!! Form::radio(
                    $label,
                    "yes",
                    $record->$label === "yes"
                ) !!}
        </span>
        <span class="input-group">
            {!! Form::label($label, "no") !!} &nbsp;
                {!! Form::radio(
                    $label,
                    "no",
                    $record->$label === "no"
                ) !!}
        </span>
    </div>
</div>
