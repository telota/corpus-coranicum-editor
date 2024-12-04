<div class="panel panel-default">
    <div class="panel-heading">Super Category</div>
    <div class="panel-body">
        <div class="input-group">
            {!! Form::select('supercategory',
            \App\Models\Intertexts\IntertextCategory::getAllSuperCategoriesSelect(),
             empty($record->supercategory) ? 0 : $record->supercategory) !!}
        </div>
    </div>
</div>
@if(isset($record->id))
    @include("intertext_categories.checkboxes.information-authors")
@endif
