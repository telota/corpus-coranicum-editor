<div class="panel panel-default">
    <div class="panel-heading">Source</div>
    <div class="panel-body">
        <div class="input-group">
            {!! Form::select($label,
            \App\Models\Intertexts\IntertextSource::getAllSelect(),
             empty($record->source_id) ? 0 : $record->source_id) !!}
        </div>

        <hr>

{{--        <a href="#">--}}
{{--            <div class="btn btn-primary">--}}
{{--                <span class="glyphicon glyphicon-plus"></span> Aufbewahrungsort--}}
{{--            </div>--}}
{{--        </a>--}}

    </div>
</div>

