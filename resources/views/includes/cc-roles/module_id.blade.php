<div class="panel panel-default">
    <div class="panel-heading">Module</div>
    <div class="panel-body">
        <div class="input-group">
            {!! Form::select($label,
            \App\Models\GeneralCC\Module::getAllSelect(),
             empty($record->module_id) ? 0 : $record->module_id) !!}
        </div>
    </div>
</div>
