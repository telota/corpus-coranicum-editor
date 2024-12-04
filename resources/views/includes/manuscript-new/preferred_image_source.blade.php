<div class="panel panel-default">
    <div class="panel-heading">Bevorzugte Bildquelle</div>
    <div class="panel-body">
        <div class="input-group">
            {!! Form::select($label,
            array_combine($record->getAllImageSources()->toArray(), $record->getAllImageSources()->toArray()),
            $record->preferred_image_source) !!}
        </div>
        <hr>
    </div>
</div>

