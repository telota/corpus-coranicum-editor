{!! Form::model($record, array("action" => $action, "files" => isset($allowFileUpload) ? $allowFileUpload : false))  !!}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>--}}

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
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

    @elseif(strtolower($label) == "is_online")

        @if(Auth::user()->hasRole("admin") && in_array("webtauglich", $editAdmin))

            @include("includes.intertexts.select_online", array(
                "options" => array(2 => "Webtauglich", 1 => "Webtauglich (ohne Bild)", 0 => "Nicht webtauglich"),
                "default" => empty($record->is_online) ? 0 : $record->is_online
                ))

        @elseif((!(Auth::user()->hasRole("admin")) && !(in_array("webtauglich", $editAdmin))) || empty($editAdmin))

            @include("includes.intertexts.select_online", array(
                "options" => array(2 => "Webtauglich", 1 => "Webtauglich (ohne Bild)", 0 => "Nicht webtauglich"),
                "default" => empty($record->is_online) ? 0 : $record->is_online
                ))

        @endif
    @elseif(in_array(strtolower($label), $editRadioButton))

        @include("includes.forms.radio-button")
    @else

        <div class="panel panel-default">

            <div class="panel-heading">
                <span class="panel-title">{{ ucfirst($label) }}</span>
            </div>

            <div class="panel-body">
                {!! Form::text($label, trim(strip_tags($content)),  array("class" => "form-control")) !!}
            </div>

        </div>

    @endif

@endforeach

@if($record->id)

    @include("intertexts.checkboxes.authors")

@endif
<hr>

{!! Form::Button('<i class="glyphicon glyphicon-save"></i> Speichern',
    array("class" => "btn btn-primary", "type" => "submit")) !!}

{!! Form::close() !!}
@include('components.summernote.zotero')
@include('components.summernote.intertexts')

