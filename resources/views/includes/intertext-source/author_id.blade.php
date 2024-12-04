<div class="panel panel-default">
    <div class="panel-heading">
        <span class="panel-title">Source Author</span>
        </div>
    <div class="panel-body">
        <div class="input-group">
            {!! Form::select($label,
            \App\Models\Intertexts\SourceAuthor::getAllSelect(),
             empty($record->author_id) ? 0 : $record->author_id) !!}
        </div>
    </div>
</div>
@if(isset($record->id))
@include("intertext_sources.checkboxes.information-authors")
@endif
