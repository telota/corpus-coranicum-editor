{!! Form::model($record, array("action" => $action, "files" => isset($allowFileUpload) ? $allowFileUpload : false)) !!}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php

if (!isset($record->editLarge)) {
    $editLarge = array();
} else {
    $editLarge = $record->editLarge;
}

if (!isset($record->editIgnore)) {
    $editIgnore = array();
} else {
    $editIgnore = $record->editIgnore;
}

if (!isset($record->editAlter)) {
    $editAlter = array();
} else {
    $editAlter = $record->editAlter;
}

if (!isset($record->editAdmin)) {
    $editAdmin = array();
} else {
    $editAdmin = $record->editAdmin;
}

if (!isset($record->editRadioButton)) {
    $editRadioButton = array();
} else {
    $editRadioButton = $record->editRadioButton;
}

$path = explode("/", Request::path())[0];

?>

@foreach($record->toArray() as $label => $content)

@if(in_array(strtolower($label), $editLarge))

@include("includes.forms.summernote")

@elseif(in_array(strtolower($label), $editIgnore))

@elseif(in_array(strtolower($label), $editAlter))

@include("includes." . $path . "." . strtolower($label))

@elseif(in_array(strtolower($label), $editRadioButton))

@include("includes.forms.radio-button")
@else

<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title">{{ ucfirst($label) }}</div>
    </div>

    <div class="panel-body">
        {!! Form::text($label, is_string($content) ? trim(strip_tags($content)) : "", array("class" => "form-control")) !!}
    </div>

</div>

@endif

@endforeach
@include("includes.manuscript-new.date")
{{--@include("manuscript_new.antiquity-market")--}}
@include("manuscript_new.checkboxes.funders")
@include("manuscript_new.checkboxes.attributed-to")
@include("manuscript_new.checkboxes.script-styles")
@include("manuscript_new.checkboxes.provenances")
@include("manuscript_new.checkboxes.rwt-provenances")
@include("manuscript_new.checkboxes.diacritic")
@include("manuscript_new.checkboxes.reading-signs")
@include("manuscript_new.checkboxes.reading-signs-function")
@include("manuscript_new.checkboxes.verse-segmentation")
@include("manuscript_new.checkboxes.authors")

<hr>

{!! Form::Button('<i class="glyphicon glyphicon-save"></i> Speichern',
array("class" => "btn btn-primary", "type" => "submit")) !!}


{!! Form::close() !!}
@include('components.summernote.zotero')
@include('components.summernote.intertexts')
