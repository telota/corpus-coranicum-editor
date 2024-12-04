@extends("layouts.master")

@section("title")

    Neues Übersetzungslabel

@endsection

@section("content")

    {!! Form::model(new \App\Models\Translation(), array("action" => array([App\Http\Controllers\TranslationController::class, 'store']), "method" => "POST"))  !!}

    <div class="input-group">

        {!! Form::label("key", ucfirst("Key"), array("class" => "input-group-addon")) !!}
        {!! Form::text("key", "", array("class" => "form-control")) !!}

    </div>

    @include("includes.forms.summernote", array(
        "label" => "deutsch",
        "content" => ""
    ))

    @include("includes.forms.summernote", array(
        "label" => "englisch",
        "content" => ""
    ))

    @include("includes.forms.summernote", array(
        "label" => "französisch",
        "content" => ""
    ))

    @include("includes.forms.summernote", array(
        "label" => "arabisch",
        "content" => ""
    ))

    @include("includes.forms.summernote", array(
        "label" => "persisch",
        "content" => ""
    ))

    @include("includes.forms.summernote", array(
        "label" => "russisch",
        "content" => ""
    ))

    @include("includes.forms.summernote", array(
        "label" => "türkisch",
        "content" => ""
    ))

    {!! Form::Button('<i class="glyphicon glyphicon-save"></i> Speichern',
    array("class" => "btn btn-primary", "type" => "submit")) !!}

    {!! Form::close() !!}

    @include('components.summernote.zotero')
    @include('components.summernote.intertexts')
@endsection

