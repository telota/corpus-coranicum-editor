<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">Category</div>
    </div>
    <div class="panel-body">
        <div class="input-group">
            {!! Form::select("category_id", \App\Models\Intertexts\IntertextCategory::toSelectArray(), $record->category_id) !!}
        </div>
    </div>
</div>
