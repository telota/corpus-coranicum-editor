<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">Sister Leaves</div>
    </div>
    <div class="panel-body">
        <h5>Choose Original Codex..</h5>
        <div class="input-group">
            {!! Form::select("original_codex_id", \App\Models\Manuscripts\ManuscriptOriginalCodex::toSelectArray(),
                empty($record->original_codex_id) ? 1 : $record->original_codex_id) !!}
        </div>

        <p>or..</p>

        <h5>Choose the corresponding Manuscript.. </h5>
        <div class="input-group">
            {!! Form::select("original_codex_manuscript", \App\Models\Manuscripts\ManuscriptNew::toSelectArray(),
                empty($record->original_codex_id) ? $record->id : $record->originalCodex->manuscripts->first()->id) !!}
        </div>
    </div>
</div>
