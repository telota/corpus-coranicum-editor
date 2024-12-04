<div class="panel panel-default">
    <div class="panel-heading">Land</div>
    <div class="panel-body">
        <div class="input-group">
            {!! Form::select($label,
            $countries,
            $record->country_code) !!}
        </div>

    </div>
</div>

