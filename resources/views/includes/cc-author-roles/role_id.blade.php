<div class="panel panel-default">
    <div class="panel-heading">Role</div>
    <div class="panel-body">
        <div class="input-group">
            {!! Form::select($label,
            \App\Models\GeneralCC\CCRole::getAllSelect(),
             empty($record->role_id) ? 0 : $record->role_id) !!}
        </div>
    </div>
</div>
