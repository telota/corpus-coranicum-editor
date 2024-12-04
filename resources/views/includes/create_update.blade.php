{!! Form::model($record, array("action" => $action, "files" => isset($allowFileUpload) ? $allowFileUpload : false))  !!}

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

        $path = explode("/", Request::path())[0];

?>

@foreach($record->toArray() as $label => $content)

    @if(in_array(strtolower($label), $editLarge))

        @include("includes.forms.summernote", ["zotero" => $zotero])

    @elseif(in_array(strtolower($label), $editIgnore))

    @elseif(in_array(strtolower($label), $editAlter))

        @include("includes." . $path . "." . strtolower($label))

    @elseif(strtolower($label) == "webtauglich")

        @if(Auth::user()->hasRole("admin") && in_array("webtauglich", $editAdmin))

            @include("includes.forms.select", array(
                "options" => array("ja" => "Webtauglich", "ohneBild" => "Webtauglich (ohne Bild)", "nein" => "Nicht webtauglich", ),
                "default" => empty($record->webtauglich) ? "nein" : $record->webtauglich
                ))

        @elseif((!(Auth::user()->hasRole("admin")) && !(in_array("webtauglich", $editAdmin))) || empty($editAdmin))

            @include("includes.forms.select", array(
                "options" => array("ja" => "Webtauglich", "ohneBild" => "Webtauglich (ohne Bild)", "nein" => "Nicht webtauglich", ),
                "default" => empty($record->webtauglich) ? "nein" : $record->webtauglich
                ))

        @endif

    @elseif(strtolower($label) == "is_online")


        @if(Auth::user()->hasRole("admin") && in_array("webtauglich", $editAdmin))
            @include("includes.forms.select", array(
                "options" => array(2 => "Webtauglich", 1 => "Webtauglich (ohne Bild)", 0 => "Nicht webtauglich"),
                "default" => empty($record->is_online) ? 0 : $record->is_online
                ))

        @elseif((!(Auth::user()->hasRole("admin")) && !(in_array("webtauglich", $editAdmin))) || empty($editAdmin))

            @include("includes.forms.select", array(
                "options" => array(2 => "Webtauglich", 1 => "Webtauglich (ohne Bild)", 0 => "Nicht webtauglich"),
                "default" => empty($record->is_online) ? 0 : $record->is_online
                ))

        @endif

    @else

        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="panel-title">{{ ucfirst($label) }}</div>
            </div>

            <div class="panel-body">
                {!! Form::text($label, trim(strip_tags($content)),  array("class" => "form-control")) !!}
            </div>

        </div>

    @endif

@endforeach


<hr>


{!! Form::Button('<i class="glyphicon glyphicon-save"></i> Speichern',
    array("class" => "btn btn-primary", "type" => "submit")) !!}

{!! Form::close() !!}
@include('components.summernote.zotero')
@include('components.summernote.intertexts')
