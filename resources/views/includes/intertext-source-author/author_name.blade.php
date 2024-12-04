<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title">{{ ucfirst($label) }}</div>
    </div>

    <div class="panel-body">
        {!! Form::text($label, trim(strip_tags($content)),  array("class" => "form-control")) !!}
    </div>

</div>
@if(isset($record->id))
    @include("intertext_source_authors.checkboxes.information-authors")
@endif
